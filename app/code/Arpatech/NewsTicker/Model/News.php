<?php
/**
 * Arpatech Software.
 *
 * @category  Arpatech
 * @package   Arpatech_NewsTicker
 * @author    Arpatech
 * @copyright Copyright (c) 2010-2016
 * @license
 */
namespace Arpatech\NewsTicker\Model;

use Arpatech\NewsTicker\Api\Data\NewsInterface;
use Magento\Framework\DataObject\IdentityInterface;

class News extends \Magento\Framework\Model\AbstractModel implements NewsInterface, IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**#@+
     * News Status
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * NewsTicker News cache tag
     */
    const CACHE_TAG = 'wk_newsticker_news';

    /**
     * @var string
     */
    protected $_cacheTag = 'wk_newsticker_news';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'wk_newsticker_news';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Arpatech\NewsTicker\Model\ResourceModel\News');
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteNews();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route News
     *
     * @return \Arpatech\NewsTicker\Model\News
     */
    public function noRouteNews()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Prepare seller's statuses.
     * Available event newsticker_news_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Approved'), self::STATUS_DISABLED => __('Disapproved')];
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Arpatech\NewsTicker\Api\Data\NewsInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}
