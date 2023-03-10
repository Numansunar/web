/* http://keith-wood.name/keypad.html
   Turkish localisation for the jQuery keypad extension
   Written by Yücel Kandemir(yucel{at}21bilisim.com) September 2010. */
(function($) { // hide the namespace
	$.keypad.regional['tr'] = {
		buttonText: '...', buttonStatus: 'Aç',
		closeText: 'Kapat', closeStatus: 'Klavyeyi Kapatır',
		clearText: 'Sil', clearStatus: 'İçerisini Temizler',
		backText: 'Geri Al', backStatus: 'Son Karakteri Siler.',
		shiftText: 'Büyüt', shiftStatus: 'Büyük Harfle Yazmak İçin Seçiniz.',
		spacebarText: '&nbsp;', spacebarStatus: '',
		enterText: 'Enter', enterStatus: '',
		tabText: '›', tabStatus: '',
    	alphabeticLayout: $.keypad.qwertyAlphabetic,
	    fullLayout: $.keypad.qwertyLayout,
    	isAlphabetic: $.keypad.isAlphabetic,
	    isNumeric: $.keypad.isNumeric,
    	isRTL: false};
	$.keypad.setDefaults($.keypad.regional['tr']);
})(jQuery);
