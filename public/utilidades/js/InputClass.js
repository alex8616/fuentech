///Para poner hora y minutos
function setCurrentTime() {
    const inputs = document.querySelectorAll('.convertTime');
    const now = new Date();

    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');

    const currentTime = `${hours}:${minutes}`;

    inputs.forEach(input => {
        input.value = currentTime;
    });
}

///Para formatear fecha en  10/02/1998
function formatearFecha(fecha) {
    const fechaObj = new Date(fecha);
    const year = fechaObj.getFullYear();
    const month = ('0' + (fechaObj.getMonth() + 1)).slice(-2);
    const day = ('0' + fechaObj.getDate()).slice(-2);
    const hours = ('0' + fechaObj.getHours()).slice(-2);
    const minutes = ('0' + fechaObj.getMinutes()).slice(-2);
    const seconds = ('0' + fechaObj.getSeconds()).slice(-2);
    
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

///Para los numeros poner 0.00
function InputNumberConver() {
    const inputs = document.querySelectorAll('.convertNumber');
    inputs.forEach(input => {
        input.value = '0.00';
        input.addEventListener('focus', function() {
            if (this.value === '0.00') {
                this.value = '';
            }
        });
        input.addEventListener('blur', function() {
            if (this.value === '' || isNaN(this.value)) {
                this.value = '0.00';
            } else {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^\d.]/g, ''); 
        });
    });
}

///Para poner fecha actual calendario
function InputDateConver(){
     const dateInputs = document.querySelectorAll('.convertDate');
    dateInputs.forEach(input => {
        const today = new Date().toISOString().split('T')[0];
        input.value = today;

        input.addEventListener('keydown', function(e) {
            e.preventDefault();
        });

        input.addEventListener('click', function() {
            this.showPicker(); 
        });
    });
}

//Para convertir minusculas a mayusculas
function transformInputsToUpperCaseAndValidateMonto() {
    $('.convertmayusculas').on('input', function() {
        var $this = $(this);
        var start = this.selectionStart;
        var value = $this.val();
        
        value = value.toUpperCase();
        $this.val(value);
        
        this.setSelectionRange(start, start);
    });

    $('.onlynumber').on('keypress', function(event) {
        var key = event.which;
        if (!(key >= 48 && key <= 57) && key !== 46 && key !== 8) {
            event.preventDefault();
        }
    });

    $('.convert').each(function() {
        var value = $(this).val();
        if ($(this).is('input[type="text"]') || $(this).is('textarea')) {
            $(this).val(value.toUpperCase());
        }
        if ($(this).attr('id') === 'monto') {
            if (!value || isNaN(value)) {
                value = '0.00'; // Si no se ingresa un valor válido, establece 0.00
            } else {
                value = parseFloat(value).toFixed(2); // Redondear a dos decimales
            }
            $(this).val(value);
        }
    });
    $('.convert').on('focus', function() {
        var value = $(this).val();
        if (value === '0.00') {
            $(this).val(''); 
        }
    });
    $('.convert').on('blur', function() {
        var value = $(this).val();
        if (!value) {
            $(this).val('0.00'); // Restablece a 0.00 si se queda vacío
        } else if ($(this).attr('id') === 'monto') {
            $(this).val(parseFloat(value).toFixed(2)); // Redondea a dos decimales
        }
    });
}
