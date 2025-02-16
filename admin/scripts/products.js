let add_product_form = document.getElementById('add_product_form');

add_product_form.addEventListener('submit',function(e){
  e.preventDefault();
  add_product();
});


function add_product()
{
  let data = new FormData();
  data.append('add_product','');
  data.append('name',add_product_form.elements['name'].value);
  data.append('price',add_product_form.elements['price'].value);
  data.append('quantity',add_product_form.elements['quantity'].value);
  data.append('desc',add_product_form.elements['desc'].value);

  let features = [];
  add_product_form.elements['features'].forEach(el =>{
    if(el.checked){
      features.push(el.value);
    }
  });

  let facilities = [];
  add_product_form.elements['facilities'].forEach(el =>{
    if(el.checked){
      facilities.push(el.value);
    }
  });

  data.append('features',JSON.stringify(features));
  data.append('facilities',JSON.stringify(facilities));

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/products.php",true);
    
    xhr.onload = function(){
    var myModal = document.getElementById('add-product');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
      
      if(this.responseText == 1){
        alert('success','New product Added');
        add_product_form.reset();
        get_all_products();
       
      }
      else{
        alert('error','Server Down!');
      }
   }
  
     xhr.send(data);
}

function get_all_products()
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/products.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
  xhr.onload = function(){
    document.getElementById('product-data').innerHTML = this.responseText;
   }
  
   xhr.send('get_all_products');

}

let edit_product_form = document.getElementById('edit_product_form');

function edit_details(id)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/products.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function(){
    let data = JSON.parse(this.responseText);

    edit_product_form.elements['name'].value = data.productdata.name;
   edit_product_form.elements['price'].value = data.productdata.price;
    edit_product_form.elements['quantity'].value = data.productdata.quantity;
    edit_product_form.elements['desc'].value = data.productdata.description;
    edit_product_form.elements['product_id'].value = data.productdata.id;

    edit_product_form.elements['features'].forEach(el =>{
     if(data.features.includes(Number(el.value))){
      el.checked = true;
     }
  });

    edit_product_form.elements['facilities'].forEach(el =>{
     if(data.facilities.includes(Number(el.value))){
      el.checked = true;
     }
  });
    
   }
  
     xhr.send('get_product='+id);
}

edit_product_form.addEventListener('submit',function(e){
  e.preventDefault();
  submit_edit_product();
});

function submit_edit_product()
{
  let data = new FormData();
  data.append('edit_product','');
  data.append('product_id',edit_product_form.elements['product_id'].value);
  data.append('name',edit_product_form.elements['name'].value);
  data.append('price',edit_product_form.elements['price'].value);
  data.append('quantity',edit_product_form.elements['quantity'].value);
  data.append('desc',edit_product_form.elements['desc'].value);

  let features = [];
  edit_product_form.elements['features'].forEach(el =>{
    if(el.checked){
      features.push(el.value);
    }
  });

  let facilities = [];
  edit_product_form.elements['facilities'].forEach(el =>{
    if(el.checked){
      facilities.push(el.value);
    }
  });

  data.append('features',JSON.stringify(features));
  data.append('facilities',JSON.stringify(facilities));

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/products.php",true);
    
    xhr.onload = function(){
    var myModal = document.getElementById('edit-product');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
      
      if(this.responseText == 1){
        alert('success','product data edited');
        edit_product_form.reset();
        get_all_products();
       
      }
      else{
        alert('error','Server Down!');
      }
   }
  
     xhr.send(data);
}

function toggle_status(id,val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/products.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
  xhr.onload = function(){
     if(this.responseText==1){
      alert('sucess','Status toggled !');
      get_all_products()
     }
     else{
      alert('sucess','Server Down !');
     }
   }
  
   xhr.send('toggle_status='+id+'&value='+val);

}

let add_image_form = document.getElementById('add_image_form');

add_image_form.addEventListener('submit',function(e){
  e.preventDefault();
  add_image();
});

function add_image()
{
  let data = new FormData();
  data.append('image',add_image_form.elements['image'].files[0]);
  data.append('product_id',add_image_form.elements['product_id'].value);
  data.append('add_image','');


    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/products.php",true);
    
    xhr.onload = function()
    {
       if(this.responseText == 'inv_img'){
        alert('error','Only JPG, WEBP or PNG Images are Allowed!','image-alert');
      }
      else if(this.responseText == 'inv_size'){
        alert('error','Images Should be less then 2mb!','image-alert');
      }
      else if(this.responseText == 'upd_failed'){
        alert('error','Images upload failed. Server Down!','image-alert');
      }
      else{
        alert('success','New Image Added','image-alert');
        product_images(add_image_form.elements['product_id'].value,document.querySelector("#product-images .modal-title").innerText)
        add_image_form.reset();           
      }
    }
    xhr.send(data);
}

function product_images(id,rname)
{
  document.querySelector("#product-images .modal-title").innerText = rname;
  add_image_form.elements['product_id'].value = id;
  add_image_form.elements['image'].value = '';

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/products.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
  xhr.onload = function(){
     document.getElementById('product-image-data').innerHTML = this.responseText;
   }
  
   xhr.send('get_product_images='+id);

}

function rem_image(img_id,product_id)
{
  let data = new FormData();
  data.append('image_id',img_id);
  data.append('product_id',product_id);
  data.append('rem_image','');


    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/products.php",true);
    
    xhr.onload = function()
    {
       if(this.responseText == 1){
        alert('success','Image Removed','image-alert');
        product_images(product_id,document.querySelector("#product-images .modal-title").innerText);
      }
      else{
        alert('error','Image removal failed!','image-alert');
      }
    }
    xhr.send(data);
}

function thumb_image(img_id,product_id)
{
  let data = new FormData();
  data.append('image_id',img_id);
  data.append('product_id',product_id);
  data.append('thumb_image','');


    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/products.php",true);
    
    xhr.onload = function()
    {
       if(this.responseText == 1){
        alert('success','Image Thumbnail Changed','image-alert');
        product_images(product_id,document.querySelector("#product-images .modal-title").innerText);
      }
      else{
        alert('error','Thumbnail removal failed!','image-alert');
      }
    }
    xhr.send(data);
}

function remove_product(product_id)
{
  if(confirm("Are you sure, you want to delete this product?"))
  {
    let data = new FormData();
    data.append('product_id',product_id);
    data.append('remove_product','');
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/products.php",true);
    
    xhr.onload = function()
    {
       if(this.responseText == 1){
        alert('success','product Removed!');
        get_all_products();
      }
      else{
        alert('error','product Removal Failed!');
      }
    }
    xhr.send(data);
  }
}

window.onload = function(){
  get_all_products();
}