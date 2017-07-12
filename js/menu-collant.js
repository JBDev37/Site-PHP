(function(){
	var scrollY = function(){
		var supportPageOffset = window.pageXOffset !== undefined;
		var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");
		return supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
	}

var elements = document.querySelectorAll('[data-sticky]')
for (var i=0; i< elements.length; i++){
	(function(element){
		//Lorsque l'on scroll si le menu sort de l'ecran alors il devient fixe
		var rect = element.getBoundingClientRect()
		var offset = parseInt(element.getAttribute('data-offset') || 0, 10)
		var top = rect.top + scrollY()
		var fake = document.createElement('div')
		fake.style.width = rect.width + "px"
		fake.style.height = rect.height + "px"

		// Fonctions
		var onScroll = function (){
				var hasScrollClass = element.classList.contains('fixed')
				if (scrollY() > top - offset && !hasScrollClass) {
                    console.log('add')
				element.classList.add('fixed')
				element.style.top = offset + "px"
				element.style.width = rec.width + "px"	
				element.parentNode.insertBefore(fake, element)	
			} else if (scrollY() < top - offset && hasScrollClass){
                    console.log('remove')
				element.classList.remove('fixed')
				element.parentNode.removeChild(fake)			
			}
		}

		var onResize = function(){
			element.style.width = "auto"
			element.classList.remove('fixed')
			fake.style.display = "none"
			rect =  element.getBoundingClientRect()
			top = rect.top + scrollY()
			fake.style.width = rect.width + "px"
		    fake.style.height = rect.height + "px"
		    fake.style.display = "block"
		    onScroll()
		}

		//Listener
		window.addEventListener('scroll', onScroll)
		window.addEventListener('resize', onResize)


    })(elements[i])
}

})()