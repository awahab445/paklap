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
namespace Arpatech\NewsTicker\Block\Adminhtml\News;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Initialize NewsTicker News Edit Block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'news_id';
        $this->_blockGroup = 'Arpatech_NewsTicker';
        $this->_controller = 'adminhtml_news';
        parent::_construct();
        if ($this->_isAllowedAction('Arpatech_NewsTicker::news')) {
            $this->buttonList->update('save', 'label', __('Save News'));
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * Retrieve text for header element depending on loaded news
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('newsticker_news')->getId()) {
            $title = $this->_coreRegistry->registry('newsticker_news')->getTitle();
            $title = $this->escapeHtml($title);
            return __("Edit News '%'", $title);
        } else {
            return __('New News');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
