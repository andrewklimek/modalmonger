(function(){
document.addEventListener('DOMContentLoaded', function(){
	var triggers = document.querySelectorAll('[data-modalmonger-trigger]' + urlTrigger.selector );
	var tl = triggers.length;
	if (tl){
		var masks = document.querySelectorAll('div[id|=modalmonger]');
		var ml = masks.length;
		var x = document.querySelectorAll('a.modalmonger-close');
		var xl = x.length;
			
		function mongerModalTrigger(e){
			if ( this.hasAttribute('data-modalmonger-trigger') ){
				var id = this.getAttribute('data-modalmonger-trigger');
			} else {// href prefix
				var id = this.href.split( urlTrigger.prefix )[1];
			}
			if (id){
				document.getElementById('modalmonger-' + id).style.display = 'block';
			} else {// Cases of href prefix but no suffix.. hopefully only one modal
				document.querySelector('div[id|=modalmonger]').style.display = 'block';
			}
			document.body.className += ' modalmonger';
			e.preventDefault();
			
			document.addEventListener('keyup', modalEscKey );
		}
		function modalEscKey(e){
			if( e.keyCode === 27 ) {
				document.removeEventListener('keyup', modalEscKey );
				for ( var i = 0; i < ml; ++i ){
					masks[i].style.display = 'none';
				}
				document.body.className = document.body.className.replace(/ modalmonger/g,'');
			}
		}
		function mongerModalClose(e){
			var id = e.currentTarget.getAttribute('data-modalmonger');
			document.getElementById( 'modalmonger-' + id ).style.display = 'none';
			document.body.className = document.body.className.replace(/ modalmonger/g,'');
			e.preventDefault();
		}
		function mongerModalMask(e){
			if ( e.target === this ) {
				this.style.display = 'none';
				document.body.className = document.body.className.replace(/ modalmonger/g,'');
			}
		}
			
		for ( var i = 0; i < tl; ++i ){
			triggers[i].addEventListener('click', mongerModalTrigger );
		}
		for ( var i = 0; i < ml; ++i ){
			masks[i].addEventListener('click', mongerModalMask );
		}
		for ( var i = 0; i < xl; ++i ){
			x[i].addEventListener('click', mongerModalClose );
		}
	}//if any triggers on page
});// DOM Loaded
})();