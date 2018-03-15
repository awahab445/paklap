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
namespace Arpatech\NewsTicker\Block\Adminhtml\News\Edit;

/**
 * Adminhtml NewsTicker News Edit Form
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('news_form');
        $this->setTitle(__('News Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('newsticker_news');
        $form = $this->_formFactory->create(
            ['data' => [
                        'id' => 'edit_form',
                        'enctype' => 'multipart/form-data',
                        'action' => $this->getData('action'),
                        'method' => 'post']
                    ]
        );
        $form->setHtmlIdPrefix('news_');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('News Information'), 'class' => 'fieldset-wide']
        );
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $fieldset->addField(
            'news_content',
            'textarea',
            ['name' => 'news_content', 'label' => __('News'), 'title' => __('News'), 'required' => true]
        );
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
