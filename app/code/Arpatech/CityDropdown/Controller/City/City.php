<?php 
namespace Arpatech\CityDropdown\Controller\City;

class City extends \Magento\Framework\App\Action\Action
{
	/**
	 * @var PageFactory
	 */
	protected $jsonResultFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
		\Arpatech\CityDropdown\Model\CityDropdownFactory $citymodel

	)
	{
		parent::__construct($context);
		$this->jsonResultFactory = $jsonResultFactory;
		$this->_citymodel = $citymodel;

	}
	
	public function execute()
	{
		 $result = $this->jsonResultFactory->create();
		 $city_data = $this->_citymodel->create();
	     $cities = $city_data->getCollection();

		$city_array = array();
		foreach ($cities as $city)
		{
			$city_name = $city->getCityName();
			$city_label = $city->getCityCode();

			$city_array[] =
				([
					'label' => $city_label,
					'value' => $city_name
				]);
		}

		$result->setData([
			$city_array
		]);

		return $result;
	}
} 
?>