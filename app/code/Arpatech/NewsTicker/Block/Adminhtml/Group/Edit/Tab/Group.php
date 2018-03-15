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

use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Widget\Form\Generic;

class Group extends Generic implements TabInterface
{
    /**
    * Prepare form
    *
    * @return $this
    */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('newsticker_group');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('group_');
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Group Information'), 'class' => 'fieldset-wide']
            );
            if ($model->getId()) {
                $fieldset->addField('id', 'hidden', ['name' => 'group_id']);
            }
            $fieldset->addField(
                'name',
                'text',
                [
                    'name' => 'name',
                    'label' => __('Group Name'),
                    'title' => __('Name'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'title',
                'text',
                [
                    'name' => 'title',
                    'label' => __('Group Title'),
                    'title' => __('Title'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'code',
                'text',
                [
                    'name' => 'code',
                    'label' => __('Group Code'),
                    'title' => __('Code'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'direction',
                'select',
                [
                    'label' => __('Direction'),
                    'title' => __('Direction'),
                    'name' => 'direction',
                    'required' => true,
                    'options' => ['left' => __('Left'), 'right' => __('Right')]
                ]
            );
            $fieldset->addField(
                'display_type',
                'select',
                [
                    'label' => __('Display Type'),
                    'title' => __('Display Type'),
                    'name' => 'display_type',
                    'required' => true,
                    'options' => ['fade' => __('Fade'), 'swing' => __('swing'),'linear' => __('linear')]
                ]
            );
            $fieldset->addField(
                'fade_in_speed',
                'text',
                [
                    'name' => 'fade_in_speed',
                    'label' => __('Group FadeIn Speed'),
                    'title' => __('Group FadeIn Speed'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'fade_out_speed',
                'text',
                [
                    'name' => 'fade_out_speed',
                    'label' => __('Group FadeOut Speed'),
                    'title' => __('Group FadeOut Speed'),
                    'required' => true,
                ]
            );
            $fieldset->addField(
                'speed',
                'text',
                [
                    'name' => 'speed',
                    'label' => __('Group Speed'),
                    'title' => __('Group Speed'),
                    'required' => true,
                ]
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
            $this->setForm($form);
            return parent::_prepareForm();
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

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Gallery Data');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Gallery Data');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
