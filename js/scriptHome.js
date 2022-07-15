const downIcon=document.getElementById("down"),
      dicdown=document.querySelector(".down"),
      EditProfile=document.getElementById('Edit'),
      updateForm=document.querySelector('.updateForm'),
      editIcon=document.querySelector('.editIcon'),
      inputFile=document.querySelector('.inputFile'),
      profileEd=document.getElementById('profile'),
      profileU=document.querySelector('.profile'),
      addTask=document.querySelector('.add'),
      blur=document.querySelector('.blur')
downIcon.onclick=()=>{
    downIcon.classList.toggle('activ')
    dicdown.classList.toggle('activ')
}

EditProfile.onclick=()=>{
    updateForm.classList.add('activ')
    document.body.classList.toggle('activ')
}

updateForm.onclick=()=>{
    updateForm.classList.toggle('activ')
    document.body.classList.toggle('activ')
}
updateForm.firstElementChild.onclick=eo=>{
    eo.stopPropagation()
}
editIcon.onclick=()=>{
    inputFile.click()
}

profileEd.src=profileU.src

inputFile.addEventListener("change",eo=>{
    let getImg=eo.target.files[0]
    url=URL.createObjectURL(getImg)
    profileEd.src=url
})

addTask.onclick=()=>{
document.body.classList.toggle('activ')
blur.classList.toggle('activ')
}
blur.onclick=()=>{
    document.body.classList.toggle('activ')
blur.classList.toggle('activ')
}
blur.firstElementChild.onclick=eo=>{
    eo.stopPropagation()
}
document.getElementById('close').onclick=()=>{
    document.body.classList.toggle('activ')
blur.classList.toggle('activ')
}