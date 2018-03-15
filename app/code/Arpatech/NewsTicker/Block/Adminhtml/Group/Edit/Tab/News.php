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
namespace Arpatech\NewsTicker\Block\Adminhtml\Group\Edit\Tab;

use Arpatech\NewsTicker\Model\ResourceModel\News\CollectionFactory as NewsCollection;

class News extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var NewsCollection
     */
    protected $_newsCollection;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param NewsCollection $newsCollection,
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $coreRegistry,
        NewsCollection $newsCollection,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_newsCollection = $newsCollection;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('newsticker_group_news');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_newsCollection
                            ->create()
                            ->addFieldToFilter("status", "1");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_group',
            [
                'type' => 'checkbox',
                'name' => 'in_group',
                'values' => $this->_getSelectedNews(),
                'index' => 'id'
            ]
        );
        $this->addColumn(
            'id',
            [
                'header' => __('Id'),
                'sortable' => true,
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn('news_content', ['header' => __('News'), 'index' => 'news_content']);
        
        return parent::_prepareColumns();
    }
    /**
     * @return string
     */
    public function getRowUrl($row)
    {
        return "javascript:void(0)";
    }

    /**
     * @return array|null
     */
    public function getGroup()
    {
        return $this->_coreRegistry->registry('newsticker_group');
    }

    /**
     * @return array|null
     */
    protected function _getSelectedNews()
    {
        $news = array_keys($this->getSelectedGroupNews());
        return $news;
    }
    
    /**
     * @return int|null
     */
    protected function _getSelectedThumb()
    {
        return $this->getGallery()->getThumbnailShow();
    }
    
    /**
     * @return array|null
     */
    public function getSelectedGroupNews()
    {
        $news = [];
        $newsIds = $this->getGroup()->getNewsIds();
        $newsIds = explode(",", $newsIds);
        foreach ($newsIds as $newsId) {
            $news[$newsId] = ['position' => $newsId];
        }
        return $news;
    }

    /**
     * @return array|null
     */
    public function getNewsIds()
    {
        $newsIds = $this->getGroup()->getNewsIds();
        return $newsIds;
    }
}
