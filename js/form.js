var waveBtn = (function () {
  'use strict';
  
  const btns = document.querySelectorAll('.wave');
  const tab = document.querySelector('.tab-bar');
  const indicator = document.querySelector('.indicator');
  const anomForm = document.getElementById('formAnom');
  const confForm = document.getElementById('formConf');        
  const anomText = document.getElementById('anomText');
  const confText = document.getElementById('confText');  
  let indi = 0;
  let boolean = 0;

  indicator.style.marginLeft = indi + 'px';

  btns.forEach((btn) => {
      btn.onmousedown = function (e) {
          const newRound = document.createElement('div');
          let x, y;

          newRound.className = 'cercle';
          this.appendChild(newRound);

          x = e.pageX - this.offsetLeft;
          y = e.pageY - this.offsetTop;

          newRound.style.left = x + "%";
          newRound.style.top = y + "%";
          newRound.classList.add("anim");

          indicator.style.marginLeft = indi + (this.dataset.num - 1) * 40.6 + '%';

          // Animación
          if (boolean) {
            
              anomText.classList.remove('fade-out');
              confText.classList.remove('fade-in');
              anomText.classList.add('fade-in');
              confText.classList.add('fade-out');
              anomForm.classList.remove('fade-out');
              confForm.classList.remove('fade-in');
              anomForm.classList.add('fade-in');
              confForm.classList.add('fade-out');
              setTimeout(() => {
                  anomForm.style.display = "inline-block";
                  confForm.style.display = "none";
                  confText.style.display = "none";
                  anomText.style.display = "block";
              }, 200);
              boolean = 0;
          } else {
              anomText.classList.remove('fade-in');
              confText.classList.remove('fade-out');
              anomText.classList.add('fade-out');
              confText.classList.add('fade-in');
              anomForm.classList.remove('fade-in');
              confForm.classList.remove('fade-out');
              anomForm.classList.add('fade-out');
              confForm.classList.add('fade-in');
              setTimeout(() => {
                  anomForm.style.display = "none";
                  confForm.style.display = "inline-block";
                  anomText.style.display = "none";
                  confText.style.display = "block";
              }, 200);
              boolean = 1;
          }

          setTimeout(() => {
              newRound.remove();
          }, 1000); 
      };
  });
})();



//Pop up
function enviarAnom(event){
  event.preventDefault();
  
  // Obtener los valores de los campos del formulario
  const fecha = document.getElementById('fecha').value;
  const localizacion = document.getElementById('localizacion').value;
  const asunto = document.getElementById('asunto').value;
  const descripcion = document.getElementById('descripcion').value;

  // Verificar que todos los campos obligatorios están completos
  if (!fecha || !localizacion || !asunto || !descripcion) {
      Swal.fire({
          title: "Campos incompletos",
          text: "Por favor, complete todos los campos antes de enviar.",
          icon: "error",
          confirmButtonColor: "#134189",
          confirmButtonText: "Volver"
      });
      return; // Evita que se proceda con el envío del formulario
  }

  Swal.fire({
    title: "Antes de enviar",
    text: "Recuerda no incluir información confidencial de pacientes o trabajadores.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#134189",
    confirmButtonText: "Enviar",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar"
  }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
            title: "¡Enviado!",
            text: "Su incidencia ha sido enviada.",
            icon: "success",
            timer: 1000,
          willClose: () => {
            document.getElementById('formAnom').submit();
          }
      });
      }
  });
}

function enviarConf(event){
  event.preventDefault();
  
  // Obtener los valores de los campos del formulario
  const nombre = document.getElementById('nombre').value;
  const email = document.getElementById('email').value;
  const fecha = document.getElementById('fechaC').value;
  const localizacion = document.getElementById('localizacionC').value;
  const asunto = document.getElementById('asuntoC').value;
  const descripcion = document.getElementById('descripcionC').value;

  // Verificar que todos los campos obligatorios están completos
  if (!nombre || !email || !fecha || !localizacion || !asunto || !descripcion) {
      Swal.fire({
          title: "Campos incompletos",
          text: "Por favor, complete todos los campos antes de enviar.",
          icon: "error",
          confirmButtonColor: "#134189",
          confirmButtonText: "Volver"
      });
      return; // Evita que se proceda con el envío del formulario
  }

  Swal.fire({
    title: "Antes de enviar",
    text: "Recuerda no incluir información confidencial de pacientes o trabajadores.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#134189",
    confirmButtonText: "Enviar",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",

  }).then((result) => {
      if (result.isConfirmed) {
          document.getElementById('formConf').submit();
          Swal.fire({
              title: "¡Enviado!",
              text: "Su incidencia ha sido enviada.",
              icon: "success",
          });
      }
  });
}

function mostrarArchivo() {
  var input = document.getElementById('fichero');
  var preview = document.getElementById('file-preview');
  var file = input.files[0];

  // Limpiar el contenido previo
  preview.innerHTML = '';

  if (file) {
      
      var fileName = document.createElement('span');
      fileName.textContent = file.name;
      preview.appendChild(fileName);

      // Si el archivo es una imagen, mostrar una miniatura
      if (file.type.startsWith('image/')) {
          var reader = new FileReader();
          
          reader.onload = function(e) {
              var img = document.createElement('img');
              img.src = e.target.result;
              img.style.width = '50px';  
              img.style.marginLeft = '10px';
              preview.appendChild(img);
          };

          reader.readAsDataURL(file);  // Lee el archivo como URL de datos para mostrar la miniatura
      }

      //Botón para eliminar el archivo
      var removeIcon = document.createElement('img');
            removeIcon.src = 'img/delete.png';  
            removeIcon.alt = 'Eliminar archivo';
            removeIcon.style.width = '20px';  
            removeIcon.style.marginLeft = '10px';
            removeIcon.style.cursor = 'pointer';  

            // Al hacer clic en el icono, limpiar el campo de archivo y la vista previa
            removeIcon.onclick = function() {
                input.value = '';  
                preview.innerHTML = '';  
            };

            preview.appendChild(removeIcon);
  }
}

function mostrarArchivoConf() {
    var input = document.getElementById('ficheroC');
    var preview = document.getElementById('file-previewC');
    var file = input.files[0];
  
    // Limpiar el contenido previo
    preview.innerHTML = '';
  
    if (file) {
        
        var fileName = document.createElement('span');
        fileName.textContent = file.name;
        preview.appendChild(fileName);
  
        // Si el archivo es una imagen, mostrar una miniatura
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '50px';  
                img.style.marginLeft = '10px';
                preview.appendChild(img);
            };
  
            reader.readAsDataURL(file);  // Lee el archivo como URL de datos para mostrar la miniatura
        }
  
        //Botón para eliminar el archivo
        var removeIcon = document.createElement('img');
              removeIcon.src = 'img/delete.png';  
              removeIcon.alt = 'Eliminar archivo';
              removeIcon.style.width = '20px';  
              removeIcon.style.marginLeft = '10px';
              removeIcon.style.cursor = 'pointer';  
  
              // Al hacer clic en el icono, limpiar el campo de archivo y la vista previa
              removeIcon.onclick = function() {
                  input.value = '';  
                  preview.innerHTML = '';  
              };
  
              preview.appendChild(removeIcon);
    }
  }
  

// Calendario personalizado
flatpickr("#fecha", {
    enableTime: true, 
    dateFormat: "Y-m-d H:i", 
    time_24hr: true, 
    locale: "es"
});

flatpickr("#fechaC", {
    enableTime: true, 
    dateFormat: "Y-m-d H:i", 
    time_24hr: true, 
    locale: "es"
});
