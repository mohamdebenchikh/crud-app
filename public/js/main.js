var dropzone = document.querySelector('.dropzone');
var input = dropzone.querySelector('input[type="file"]');
var box = dropzone.querySelector('.dropzone-box');
var preview = dropzone.querySelector('.dropzone-preview');
var image = dropzone.querySelector('#preview');
var actions = dropzone.querySelector('.dropzone-actions');
var changeButton = dropzone.querySelector('#changeImage');
var removeButton = dropzone.querySelector('#removeImage');

input.addEventListener('change', function () {
  var file = this.files[0];
  var reader = new FileReader();

  reader.onload = function (e) {
    image.src = e.target.result;
  };

  reader.readAsDataURL(file);

  box.style.display = 'none';
  preview.style.display = 'block';
});

box.addEventListener('dragover', function (e) {
  e.preventDefault();
  box.classList.add('dragover');
});

box.addEventListener('dragleave', function () {
  box.classList.remove('dragover');
});

box.addEventListener('click', function () {
  input.click();
});

box.addEventListener('drop', function (e) {
  e.preventDefault();
  box.classList.remove('dragover');

  var file = e.dataTransfer.files[0];
  var reader = new FileReader();

  reader.onload = function (e) {
    preview.src = e.target.result;
  };

  reader.readAsDataURL(file);

  placeholder.style.display = 'none';
  actions.style.display = 'block';
  preview.style.display = 'block';
});

changeButton.addEventListener('click', function () {
  input.click();
});

removeButton.addEventListener('click', function () {
  input.value = '';
  box.style.display = 'block';
  preview.style.display = 'none';
});
