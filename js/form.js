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

          // Toggle forms
          if (boolean) {
              anomForm.style.display = "inline-block";
              confForm.style.display = "none";
              confText.style.display = "none";
              anomText.style.display = "block";
              boolean = 0;
          } else {
              anomForm.style.display = "none";
              confForm.style.display = "inline-block";
              anomText.style.display = "none";
              confText.style.display = "block";
              boolean = 1;
          }

          setTimeout(() => {
              newRound.remove();
          }, 1200);
      };
  })
  
}());

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
            text: "Su información ha sido enviada.",
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
              text: ".",
              icon: "success"
          });
      }
  });
}
