/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'underscore',
    'uiRegistry',
    'Magento_Checkout/js/checkout-data',
    './select',
    'domReady!',
    'mage/url'
], function (_, registry, CheckoutData, Select, DomReady,Url) {
    'use strict';

    return Select.extend({
        defaults: {
            skipValidation: false,
            imports: {
                update: '${ $.parentName }.country_id:value'
            }
        },

        /**
         * @param {String} value
         */
        update: function (value) {
            var country = registry.get(this.parentName + '.' + 'country_id'),
                options = country.indexedOptions,
                option;

            if (!value) {
                return;
            }
            //console.log(country);
            option = options[value];
            if (this.skipValidation) {
                this.validation['required-entry'] = false;
                this.required(false);
            } else {
                if (!option['is_region_required']) {
                    this.error(false);
                    this.validation = _.omit(this.validation, 'required-entry');
                } else {
                    this.validation['required-entry'] = true;
                }

                this.required(!!option['is_region_required']);
            }
        },

        /**
         * Filters 'initialOptions' property by 'field' and 'value' passed,
         * calls 'setOptions' passing the result to it
         *
         * @param {*} value
         * @param {String} field
         */
        filter: function (value, field) {
            var optionData = this;
            var country = registry.get(this.parentName + '.' + 'country_id');
            console.log(country);
            //console.log(this.parentName);
            var option = country.indexedOptions[value];
            console.log(country.value());
            if (country) {
                this._super(value, field);

                if (option && country.value() === 'PK') {
                    //console.log('here',country.value(),option);
                    // hide select and corresponding text input field if region must not be shown for selected country
                    optionData.setVisible(true);
                    if (this.customEntry) {
                        optionData.toggleInput(false);
                        var cityOptions = '';

                        var cityajaxUrl = Url.build('drop/city/city');
                        jQuery.ajax({
                            url: cityajaxUrl,
                            type: 'GET',
                            dataType: 'json',
                            success: function (result) {
                                cityOptions = result[0];
                                if(country.value() === 'PK'){
                                optionData.setOptions(cityOptions);
                                }else{
                                    optionData.setVisible(false);
                                    optionData.toggleInput(true);
                                    country.disabled(true);
                                    //optionData.FloatFiled('left');
                                    //console.log(optionData.innerHTML());
                                }
                            }
                        })

                        //var cityOptions = [{"label":"Dadu","value":"Dadu"}, {"label":"Mandi Bahauddin","value":"Mandi Bahauddin"}, {"label":"Mardan","value":"Mardan"}, {"label":"Okara","value":"Okara"}, {"label":"Shikarpur","value":"Shikarpur"}, {"label":"Karachi","value":"Karachi"}, {"label":"Lahore","value":"Lahore"}, {"label":"Islamabad","value":"Islamabad"}, {"label":"Peshawar","value":"Peshawar"}, {"label":"Faisalabad","value":"Faisalabad"}, {"label":"Sukkar","value":"Sukkar"}, {"label":"Swat","value":"Swat"}, {"label":"Quetta","value":"Quetta"}, {"label":"Gwadar","value":"Gwadar"}, {"label":"Abbottabad","value":"Abbottabad"}, {"label":"Kohat","value":"Kohat"}, {"label":"Dera Ismail Khan","value":"Dera Ismail Khan"}, {"label":"Charsadda","value":"Charsadda"}, {"label":"Nowshera","value":"Nowshera"}, {"label":"Rawalpindi","value":"Rawalpindi"}, {"label":"Multan","value":"Multan"}, {"label":"Gujranwala","value":"Gujranwala"}, {"label":"Sargodha","value":"Sargodha"}, {"label":"Bahawalpur","value":"Bahawalpur"}, {"label":"Sialkot","value":"Sialkot"}, {"label":"Sheikhupura","value":"Sheikhupura"}, {"label":"Gujrat","value":"Gujrat"}, {"label":"Hyderabad","value":"Hyderabad"}, {"label":"Larkana","value":"Larkana"}, {"label":"Nawabshah","value":"Nawabshah"}, {"label":"Mirpur Khas","value":"Mirpur Khas"}, {"label":"Jacobabad","value":"Jacobabad"}, {"label":"Khairpur","value":"Khairpur"}, {"label":"Thatta","value":"Thatta"}, {"label":"Gilgit","value":"Gilgit"}, {"label":"Skardu","value":"Skardu"}, {"label":"Muzaffarabad","value":"Muzaffarabad"}, {"label":"Bagh","value":"Bagh"}, {"label":"Mansehra","value":"Mansehra"}, {"label":"Khuzdar","value":"Khuzdar"}, {"label":"Qilla Abdullah District","value":"Qilla Abdullah District"}, {"label":"Turbat","value":"Turbat"}, {"label":"Sibi","value":"Sibi"}, {"label":"Lasbela","value":"Lasbela"}, {"label":"Zhob","value":"Zhob"}, {"label":"Nasirabad","value":"Nasirabad"}, {"label":"Jaffarabad","value":"Jaffarabad"}, {"label":"Swabi","value":"Swabi"}, {"label":"Yazman Mandi","value":"Yazman Mandi"}, {"label":"Taxila","value":"Taxila"}, {"label":"Wazirabad","value":"Wazirabad"}, {"label":"Basti Shorekot","value":"Basti Shorekot"}, {"label":"Bhawal Nagar","value":"Bhawal Nagar"}, {"label":"chakwal","value":"chakwal"}, {"label":"Chichawatni","value":"Chichawatni"}, {"label":"Chinniot","value":"Chinniot"}, {"label":"Dera Ghazi Khan","value":"Dera Ghazi Khan"}, {"label":"Dharki","value":"Dharki"}, {"label":"Dina","value":"Dina"}, {"label":"Gambat","value":"Gambat"}, {"label":"Gujar Khan","value":"Gujar Khan"}, {"label":"Hafizabad","value":"Hafizabad"}, {"label":"Haripur","value":"Haripur"}, {"label":"Haroonabad","value":"Haroonabad"}, {"label":"Hasanabdal","value":"Hasanabdal"}, {"label":"Hawalian","value":"Hawalian"}, {"label":"Jamshoro","value":"Jamshoro"}, {"label":"Jaranwala","value":"Jaranwala"}, {"label":"Jehlum","value":"Jehlum"}, {"label":"Jhang","value":"Jhang"}, {"label":"Kabeerwala","value":"Kabeerwala"}, {"label":"Kalar Kahar","value":"Kalar Kahar"}, {"label":"Kamonki","value":"Kamonki"}, {"label":"Kandh Kot","value":"Kandh Kot"}, {"label":"Kandiaro","value":"Kandiaro"}, {"label":"Kashmore","value":"Kashmore"}, {"label":"Khairpur Mirs","value":"Khairpur Mirs"}, {"label":"Khairpur Nathan Shah","value":"Khairpur Nathan Shah"}, {"label":"Khan Pur","value":"Khan Pur"}, {"label":"Khanewal","value":"Khanewal"}, {"label":"Kharian","value":"Kharian"}, {"label":"Khurlianwala","value":"Khurlianwala"}, {"label":"Khyber","value":"Khyber"}, {"label":"Kotali","value":"Kotali"}, {"label":"Liaqatpur","value":"Liaqatpur"}, {"label":"Matiari","value":"Matiari"}, {"label":"Mian Wali","value":"Mian Wali"}, {"label":"Mian Chunnu","value":"Mian Chunnu"}, {"label":"Mirpur Azad Kashmir","value":"Mirpur Azad Kashmir"}, {"label":"Mirpurmathelo","value":"Mirpurmathelo"}, {"label":"Moro","value":"Moro"}, {"label":"Muzaffargarh","value":"Muzaffargarh"}, {"label":"Nowdero","value":"Nowdero"}, {"label":"Nowsheroferoz","value":"Nowsheroferoz"}, {"label":"Pannu Aqil","value":"Pannu Aqil"}, {"label":"Rahim Yar Khan","value":"Rahim Yar Khan"}, {"label":"Ranipur","value":"Ranipur"}, {"label":"Rato Dera","value":"Rato Dera"}, {"label":"Rohri","value":"Rohri"}, {"label":"Sadiqabad","value":"Sadiqabad"}, {"label":"Sahiwal","value":"Sahiwal"}, {"label":"Samundri","value":"Samundri"}, {"label":"Sehwan","value":"Sehwan"}, {"label":"Sekhat","value":"Sekhat"}, {"label":"Shorekot Cantt","value":"Shorekot Cantt"}, {"label":"Tando Adam","value":"Tando Adam"}, {"label":"Tando Jam","value":"Tando Jam"}, {"label":"Tando Muhammad Khan","value":"Tando Muhammad Khan"}, {"label":"Tandolayar","value":"Tandolayar"}, {"label":"Toba Tek Singh","value":"Toba Tek Singh"}, {"label":"Vehari","value":"Vehari"}, {"label":"Wah Cantt","value":"Wah Cantt"}, {"label":"Badin","value":"Badin"}, {"label":"Bhirkan","value":"Bhirkan"}, {"label":"Bhiria City","value":"Bhiria City"}, {"label":"Bhiria Road","value":"Bhiria Road"}, {"label":"Rajo Khanani","value":"Rajo Khanani"}, {"label":"Chak","value":"Chak"}, {"label":"Digri","value":"Digri"}, {"label":"Diplo","value":"Diplo"}, {"label":"Dokri","value":"Dokri"}, {"label":"Ghotki","value":"Ghotki"}, {"label":"Haala","value":"Haala"}, {"label":"Ahmadpur East","value":"Ahmadpur East"}, {"label":"Attock","value":"Attock"}, {"label":"Hub","value":"Hub"}, {"label":"Bannu","value":"Bannu"}, {"label":"Sahiwal","value":"Sahiwal"}, {"label":"Vehari","value":"Vehari"}, {"label":"Fateh Pur","value":"Fateh Pur"}, {"label":"Bhakkar","value":"Bhakkar"}, {"label":"layyah","value":"layyah"}, {"label":"Azad Kashmir ","value":"Azad Kashmir "}, {"label":"Kasur","value":"Kasur"}, {"label":"Arifwala","value":"Arifwala"}, {"label":"Lower Dir ","value":"Lower Dir "}, {"label":"Lodhran","value":"Lodhran"}, {"label":"Umerkot","value":"Umerkot"}, {"label":"Naushahro Feroze","value":"Naushahro Feroze"}, {"label":"Pakpattan","value":"Pakpattan"}, {"label":"Tando Muhammad Khan ","value":"Tando Muhammad Khan "}, {"label":"Fort Abbas","value":"Fort Abbas"}, {"label":"Khipro","value":"Khipro"},{"label":"Kamalia","value":"Kamalia"}];

                   }
                }else{
                    optionData.setVisible(false);
                    optionData.toggleInput(true);
                    country.disabled(true);
                    //optionData.FloatFiled('left');
                }
            }
        }
    });
});

