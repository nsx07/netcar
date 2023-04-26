const file = document.getElementById('file');
const submit = document.getElementById('submit');
const photo = document.getElementById('photo');

submit.addEventListener('click', () => {
  const fileReader = new FileReader();
  fileReader.onload = () => {
    photo.src = fileReader.result;
  }
  fileReader.readAsDataURL(file.files[0]);
});