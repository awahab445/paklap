<?php
 
namespace Emthemes\Ajaxblock\Observer;
 
use Magento\Framework\Event\ObserverInterface;
 
/**
 * Customer login observer
 */
class FilterContent implements ObserverInterface
{
 
    
    /**
     * Filter emthemes block
     *
     * @param  \Magento\Framework\Event\Observer $observer Observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if($block->getData('ajaxblock'))
        {
            return;
        }
        else
        {
            $block->setData('ajaxblock',true);      
            if($block->getData('type') == 'Emthemes\FilterProduct\Block\Product\ProductsList')
            {
				$block->setData('current_url',\Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface')->getCurrentUrl());
            	$data = base64_encode(json_encode($block->getData()));
				$id = uniqid("em_ajax_products_");
				$block->setData('uniqid',$id);
                $block->setData('data',$data);            
                $block->setData('filter_template','custom');
                $block->setData('custom_template','Emthemes_Ajaxblock::index_filter.phtml');
            }
        }
    }
 
}
