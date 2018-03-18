<?php
/**
 * Copyright © 2017 Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magmodules\RichSnippets\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Helper\Image;
use Magmodules\RichSnippets\Helper\General as GeneralHelper;
use Magento\Review\Model\Review\SummaryFactory;
use Magento\CatalogInventory\Model\Stock\Item as StockItem;

class Product extends AbstractHelper
{

    const XML_PATH_WEBSITE_NAME = 'magmodules_richsnippets/store/name';
    const XML_PATH_PRODUCT_ENABLE = 'magmodules_richsnippets/product/enable';
    const XML_PATH_PRODUCT_CONDITION_ENABLE = 'magmodules_richsnippets/product/condition';
    const XML_PATH_PRODUCT_CONDITION_DEFAULT = 'magmodules_richsnippets/product/condition_default';
    const XML_PATH_PRODUCT_CONDITION_ATTRIBUTE = 'magmodules_richsnippets/product/condition_attribute';
    const XML_PATH_PRODUCT_RATING_ENABLE = 'magmodules_richsnippets/product/rating';
    const XML_PATH_PRODUCT_RATING_METRIC = 'magmodules_richsnippets/product/rating_metric';
    const XML_PATH_PRODUCT_ATTRIBUTES = 'magmodules_richsnippets/product/attributes';
    const XML_PATH_MULTI_CONFIGURABLE = 'magmodules_richsnippets/product/multi_configurable';
    const XML_PATH_HIDE_ZERO_OFFER = 'magmodules_richsnippets/product/hide_offer';

    private $general;
    private $stockItem;
    private $reviewSummary;
    private $imgHelper;

    /**
     * Product constructor.
     *
     * @param Context        $context
     * @param General        $generalHelper
     * @param StockItem      $stockItem
     * @param Image          $imgHelper
     * @param SummaryFactory $reviewSummary
     */
    public function __construct(
        Context $context,
        GeneralHelper $generalHelper,
        StockItem $stockItem,
        Image $imgHelper,
        SummaryFactory $reviewSummary

    ) {
        $this->general = $generalHelper;
        $this->stockItem = $stockItem;
        $this->reviewSummary = $reviewSummary;
        $this->imgHelper = $imgHelper;
        parent::__construct($context);
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return array|bool
     */
    public function getSnippets($product)
    {
        if (!$this->general->getEnabled(self::XML_PATH_PRODUCT_ENABLE)) {
            return false;
        }

        return $this->getProductSchema($product);
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return string
     */
    public function getProductSchema($product)
    {
        $productSnippets = [];
        $typeId = $product->getTypeId();
        if ($typeId == 'configurable') {
            if ($this->general->getEnabled(self::XML_PATH_MULTI_CONFIGURABLE)) {
                $children = $product->getTypeInstance()->getUsedProducts($product);
                foreach ($children as $child) {
                    if ($child->getStatus() == 1) {
                        $productSnippets[] = $this->getProductSchemaData($child, $product);
                    }
                }
                return $productSnippets;
            }
        }

        $productSnippets[] = $this->getProductSchemaData($product);
        return $productSnippets;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Catalog\Model\Product $parent
     *
     * @return array
     */
    public function getProductSchemaData($product, $parent = null)
    {
        $productSnippets = [];
        $productSnippets['@context'] = 'http://schema.org';
        $productSnippets['@type'] = 'Product';
        $productSnippets['name'] = $product->getName();
        if ($img = $this->getImage($product, $parent)) {
            $productSnippets['image'] = $img;
        }

        $price = $this->getPrice($product);
        $hideZeroOffer = $this->general->getEnabled(self::XML_PATH_HIDE_ZERO_OFFER);
        if ($price > 0 || !$hideZeroOffer) {
            $productSnippets['offers']['@type'] = 'Offer';
            $productSnippets['offers']['priceCurrency'] = $this->general->getCurrencyCode();
            $productSnippets['offers']['price'] = $this->getPrice($product);
            if ($priceValidUntil = $this->getPriceValidUntil($product)) {
                $productSnippets['offers']['priceValidUntil'] = $priceValidUntil;
            }
            if ($itemCondition = $this->getItemCondition($product)) {
                $productSnippets['offers']['itemCondition'] = $itemCondition;
            }
            if ($availability = $this->getAvailability($product)) {
                $productSnippets['offers']['availability'] = $availability;
            }
            if ($sellerName = $this->general->getValue(self::XML_PATH_WEBSITE_NAME)) {
                $productSnippets['offers']['seller']['@type'] = 'Organization';
                $productSnippets['offers']['seller']['name'] = $sellerName;
            }
        }

        if (empty($parent)) {
            $parent = $product;
        }

        if ($rating = $this->getAggregateRating($parent)) {
            $productSnippets['aggregateRating']['@type'] = 'AggregateRating';
            $productSnippets['aggregateRating']['bestRating'] = $rating['bestRating'];
            $productSnippets['aggregateRating']['ratingValue'] = $rating['ratingValue'];
            $productSnippets['aggregateRating']['reviewCount'] = $rating['reviewCount'];
        }
        if ($attributes = $this->getExtraFiels($product)) {
            $productSnippets = array_merge($productSnippets, $attributes);
        }

        return $productSnippets;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Catalog\Model\Product $parent
     *
     * @return string
     */
    public function getImage($product, $parent = null)
    {
        $img = '';

        if ($parent && $parent->getImage()) {
            $img = $this->imgHelper->init($parent, 'product_base_image')->getUrl();
            return $img;
        }

        if ($product->getImage()) {
            $img = $this->imgHelper->init($product, 'product_base_image')->getUrl();
        }

        return $img;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return string
     */
    public function getPrice($product)
    {
        $price = $product->getFinalPrice();
        $typeId = $product->getTypeId();
        if (($typeId == 'grouped') || ($typeId == 'configurable') || ($typeId == 'bundle')) {
            $priceData = $product->getPriceInfo()->getPrice('final_price');
            $price = $priceData->getMinimalPrice()->getValue();
        }

        return number_format($price, 2, '.', '');
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return string
     */
    public function getPriceValidUntil($product)
    {
        $priceValidUntil = '';
        $special_price = $product->getSpecialPrice();
        $final_price = $product->getFinalPrice();
        if ($special_price == $final_price) {
            $priceValidUntil = $product->getSpecialToDate();
        }

        return $priceValidUntil;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return mixed|string
     */
    public function getItemCondition($product)
    {
        $itemCondition = '';
        $conditionType = $this->general->getValue(self::XML_PATH_PRODUCT_CONDITION_ENABLE);
        if ($conditionType == 1) {
            if ($itemCondition = $this->general->getValue(self::XML_PATH_PRODUCT_CONDITION_DEFAULT)) {
                $itemCondition = 'http://schema.org/' . $itemCondition . 'Condition';
            }
        }
        if ($conditionType == 2) {
            if ($attribute = $this->general->getValue(self::XML_PATH_PRODUCT_CONDITION_ATTRIBUTE)) {
                $itemCondition = $this->getAttributeValue($product, $attribute);
                if (!empty($itemCondition)) {
                    $itemCondition = 'http://schema.org/' . ucfirst($itemCondition) . 'Condition';
                }
            }
        }

        return $itemCondition;
    }

    /**
     * Returns attribute value for product
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param                                $attribute
     *
     * @return string
     */
    public function getAttributeValue($product, $attribute)
    {
        $value = '';
        if ($attr = $product->getResource()->getAttribute($attribute)) {
            $value = $product->getData($attribute);
            if ($attr->usesSource()) {
                $value = $attr->getSource()->getOptionText($value);
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
            }
        }

        return $value;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return string
     */
    public function getAvailability($product)
    {
        if ($product->getParentId()) {
            $available = $this->stockItem->load($product->getId(), 'product_id')->getIsInStock();
        } else {
            $available = $product->isAvailable();
        }

        if ($available) {
            return 'http://schema.org/InStock';
        } else {
            return 'http://schema.org/OutOfStock';
        }
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return array|bool
     */
    public function getAggregateRating($product)
    {
        if (!$this->general->getValue(self::XML_PATH_PRODUCT_RATING_ENABLE)) {
            return false;
        }
        $aggregateRating = [];
        $reviewSummary = $this->reviewSummary->create();
        $reviewSummary->setData('store_id', $this->general->getStoreId());
        $summaryModel = $reviewSummary->load($product->getId());
        if ($summaryModel->getRatingSummary() > 0) {
            $metric = $this->general->getValue(self::XML_PATH_PRODUCT_RATING_METRIC);
            $aggregateRating['bestRating'] = $metric;
            $aggregateRating['reviewCount'] = $summaryModel->getReviewsCount();
            if ($metric == 5) {
                $aggregateRating['ratingValue'] = round(($summaryModel->getRatingSummary() / 20), 2);
            } else {
                $aggregateRating['ratingValue'] = $summaryModel->getRatingSummary();
            }
        }

        return $aggregateRating;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     *
     * @return array
     */
    public function getExtraFiels($product)
    {
        $extraFields = [];
        if ($attributes = $this->general->getValue(self::XML_PATH_PRODUCT_ATTRIBUTES)) {
            $attributes = @unserialize($attributes);
            if (!is_array($attributes)) {
                return $extraFields;
            }
            foreach ($attributes as $attribute) {
                $value = $this->getAttributeValue($product, $attribute['attribute']);
                $label = $attribute['type'];
                if ($value) {
                    if ($label == 'brand') {
                        $extraFields['brand']['@type'] = 'Thing';
                        $extraFields['brand']['name'] = strip_tags($value);
                    } else {
                        $extraFields[$label] = strip_tags($value);
                    }
                }
            }
        }

        return $extraFields;
    }
}
