if(document.querySelector('#togglePassword'))
{
    document
    .getElementById("togglePassword")
    .addEventListener("click", function () {
        const passwordField = document.getElementById("password");
        const eye = document.getElementById("eye");
        const eyeSlash = document.getElementById("eyeSlash");

        // Toggle password visibility
        const isPasswordVisible = passwordField.type === "password";
        passwordField.type = isPasswordVisible ? "text" : "password";

        if(isPasswordVisible){
            eyeSlash.classList.remove('hidden')
            eye.classList.add('hidden')
        }else{
            eyeSlash.classList.add('hidden');
            eye.classList.remove('hidden')
        }
        
});
}
if (document.querySelector(".uploadProductImage")) {
    document.querySelectorAll('.uploadProductImage').forEach((elem) => {
        elem.addEventListener('change', function(ev) {
            const files = ev.target.files;
            if (files.length > 0) {
                if(files[0].size  >  2 * 1024 * 1024){
                    alert('File Size   Should  Be Under  2 MB')
                }else  if(!['image/jpg','image/jpeg','image/png'].includes(files[0].type)){
                    alert('Only  JPEG,  JPG,PNG files are allowed');
                }else{
                    const imgElement = this.nextElementSibling;  
                    if (imgElement) {
                        imgElement.setAttribute('src', URL.createObjectURL(files[0]));
                    }
                }
            }
        });
    });
}


if(document.querySelector('#category')){
    const selectElem = document.getElementById('category');
    selectElem.addEventListener('change',function(ev){
        const selectedOption = document.querySelector(`#${this.value}`);
        const subcategories = JSON.parse(selectedOption.dataset.subcategories);

        const  subCategorySelectElem  =  document.getElementById('subcategory');
        subCategorySelectElem.innerHTML = '<option value="choose" selected hidden>Select subcategory</option>';
        subcategories.forEach((elem)=>{
            const html =  `<option value="${elem}">${elem.charAt(0).toUpperCase() + elem.slice(1)}</option>`;
            subCategorySelectElem.innerHTML   += html;
        })
    })


    if(selectElem.value){
        const selectedOption = document.querySelector(`#${CSS.escape(selectElem.value)}`);
        if (selectedOption) {
            const subcategories = JSON.parse(selectedOption.dataset.subcategories);
            const subcategoriesSelected = selectedOption.dataset.subcategoriesSelected;
            
            const subCategorySelectElem = document.getElementById('subcategory');
            subCategorySelectElem.innerHTML = ''; // Clear existing options
        
            subcategories.forEach((elem) => {
                const isSelected = subcategoriesSelected === elem ? 'selected' : '';
                const optionHTML = `<option value="${elem}" ${isSelected}>${elem.charAt(0).toUpperCase() + elem.slice(1)}</option>`;
                subCategorySelectElem.innerHTML += optionHTML;
            });
        }
    }
}