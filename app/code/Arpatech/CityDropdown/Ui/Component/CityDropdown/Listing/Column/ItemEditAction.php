<?php
namespace Arpatech\CityDropdown\Ui\Component\CityDropdown\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

class ItemEditAction extends Column {

	/**
	 * @var UrlInterface
	 */
	protected $urlBuilder;


	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		UrlInterface $urlBuilder,
		array $component = [],
		array $data = []
	){
		$this->urlBuilder = $urlBuilder;
		parent::__construct($context, $uiComponentFactory, $component, $data);
	}

	public function prepareDataSource(array $dataSource){
		if (isset($dataSource['data']['items'])) {
			foreach ($dataSource['data']['items'] as & $item) {
				if (isset($item['id']) ){
					$item[$this->getData('name')]['edit'] = [
						'href' => $this->urlBuilder->getUrl(
							'city/citydropdown/edit',
							['id' => $item['id']]
						),
						'label' => __('Edit'),
						'hidden' => false,
					];

					$item[$this->getData('name')]['delete'] = [
							'href' => $this->urlBuilder->getUrl(
								'city/citydropdown/delete',
								['id' => $item['id']]
							),
							'label' => __('Delete'),
							'hidden' => false,
					];
				}
			}
		}
		return $dataSource;
	}
}
