let images = document.querySelectorAll('.containerImg');
const btnPreceed = document.querySelector('.preceed i');
const btnNext = document.querySelector('.next i');

let imgActive = 0;
images[0].classList.add('active')

let nextImg = function(){
    imgActive++
    if(imgActive==images.length){
        imgActive = 0;
    }
    images.forEach(image => {
        image.classList.remove('active')
    })
    images[imgActive].classList.add('active')
}
let previousImg = function(){
    imgActive--
    if(imgActive<0){
        imgActive = images.length-1;
    }
    images.forEach(image => {
        image.classList.remove('active')
    })
    images[imgActive].classList.add('active')
}

btnNext.addEventListener('click', nextImg)
btnPreceed.addEventListener('click', previousImg)

window.addEventListener('keydown', (e)=>{
    if(e.key === "ArrowLeft"){
        previousImg()
    }else if(e.key === "ArrowRight"){
        nextImg()
    }
})