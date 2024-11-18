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

          indicator.style.marginLeft = indi + (this.dataset.num - 1) * 24 + '%';

          // Toggle forms with animation
          if (boolean) {
            // animating the text too
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
            title: "Enviado!",
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
          document.getElementById('formConf').submit();
          Swal.fire({
              title: "Enviado!",
              text: "Su incidencia ha sido enviada.",
              icon: "success",
          });
      }
  });
}




