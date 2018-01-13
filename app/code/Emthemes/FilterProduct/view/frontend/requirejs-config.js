var config = {
  	map: {
        "*": {
            'filterslider': 'Emthemes_FilterProduct/owlcarousel/filterslider',                 
        }
    },
    paths:  {
    	  "filterslider_jquery" : "Emthemes_FilterProduct/owlcarousel/owl.carousel.min",
        "infinitescroll" : "Emthemes_FilterProduct/js/jquery.infinitescroll.min",
        "isotope": "Emthemes_FilterProduct/js/jquery.isotope",
        "manual": "Emthemes_FilterProduct/js/behaviors/manual-trigger",
    },
    "shim": {
    	"Emthemes_FilterProduct/owlcarousel/owl.carousel.min": ["jquery"],
      "Emthemes_FilterProduct/js/jquery.infinitescroll.min": ["jquery"],
      "Emthemes_FilterProduct/js/jquery.isotope": ["jquery"],
      "Emthemes_FilterProduct/js/behaviors/manual-trigger": ["jquery"],
      },  
};
 
