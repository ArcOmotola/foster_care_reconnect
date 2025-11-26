$(function(){
	
	/* Morris Area Chart */
	
	window.mA = Morris.Area({
	    element: 'morrisArea',
	    data: [
	        { m: '2013', a: 60},
	        { m: '2014', a: 1000},
	        { m: '2015', a: 240},
	        { m: '2016', a: 120},
	        { m: '2017', a: 80},
	        { m: '2018', a: 100},
	        { m: '2019', a: 300},
	    ],
	    xkey: 'm',
	    ykeys: ['a'],
	    labels: ['Foster'],
	    lineColors: ['#1b5a90'],
	    lineWidth: 2,
		
     	fillOpacity: 0.5,
	    gridTextSize: 10,
	    hideHover: 'auto',
	    resize: true,
		redraw: true
	});
	
	/* Morris Line Chart */
	
	window.mL = Morris.Line({
	    element: 'morrisLine',
	    data: [
	        { m: '2015', a: 100, b: 30},
	        { m: '2016', a: 20,  b: 60},
	        { m: '2017', a: 90,  b: 190},
	        { m: '2018', a: 50,  b: 80},
	        { m: '2019', a: 120,  b: 150},
	    ],
	    xkey: 'y',
	    ykeys: ['a', 'b'],
	    labels: ['Doctors', 'Patients'],
	    lineColors: ['#1b5a90','#ff9d00'],
	    lineWidth: 1,
	    gridTextSize: 10,
	    hideHover: 'auto',
	    resize: true,
		redraw: true
	});
	$(window).on("resize", function(){
		mA.redraw();
		mL.redraw();
	});

});