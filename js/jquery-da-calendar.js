/* Danish initialisation for the jQuery UI date picker plugin. */
jQuery(function($){
    $.datepicker.regional['da'] = {
                closeText: 'Luk',
        prevText: '&#x3c;Forrige',
                nextText: 'Næste&#x3e;',
                currentText: 'Idag',
        monthNames: ['Januar','Februar','Marts','April','Maj','Juni',
        'Juli','August','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
                dayNames: ['Søndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag'],
                dayNamesShort: ['Søn','Man','Tir','Ons','Tor','Fre','Lør'],
                dayNamesMin: ['Sø','Ma','Ti','On','To','Fr','Lø'],
                weekHeader: 'Uge',
        dateFormat: 'dd-mm-yy',
                minDate: -0,
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['da']);
});