src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" 
    const mobileBtn = document.getElementById('mobile-cta')
       nav = document.querySelector('nav')
        mobileBtnExit=document.getElementById('mobile-exit');

    mobileBtn.addEventListener('click',()=>{
        nav.classList.add('menu-btn');
    })     
    mobileBtnExit.addEventListener('click',()=>{
        nav.classList.remove('menu-btn');
    })   
  