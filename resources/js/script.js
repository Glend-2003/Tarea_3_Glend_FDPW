// ========== INICIALIZACIÓN ==========
$(document).ready(function() {
    inicializarDataTable();
    configurarEventos();
});

// ========== DATATABLES ==========
function inicializarDataTable() {
    $('#tablaParticipantes').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 10,
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: 4 } // Deshabilitar ordenamiento en columna Acciones
        ]
    });
}

// ========== CONFIGURACIÓN DE EVENTOS ==========
function configurarEventos() {
    // Scroll suave
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const target = $(this.getAttribute('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 800);
        }
    });

    // Envío del formulario de registro
    $('#registroForm').on('submit', function(e) {
        // Aquí Laravel manejará el envío
        // Este código es para referencia de validación cliente
    });

    // Botones de eliminar
    $(document).on('click', '.btn-danger', function() {
        const fila = $(this).closest('tr');
        const nombre = fila.find('td:first').text();
        
        if (confirm(`¿Está seguro de eliminar a ${nombre}?`)) {
            // Aquí irá la lógica de eliminación con Laravel
            const participanteId = $(this).data('id');
            eliminarParticipante(participanteId, fila);
        }
    });

    // Botones de editar
    $(document).on('click', '.btn-warning', function() {
        const fila = $(this).closest('tr');
        const datos = {
            id: $(this).data('id'),
            nombre: fila.find('td').eq(0).text(),
            telefono: fila.find('td').eq(1).text(),
            correo: fila.find('td').eq(2).text(),
            es_ponente: fila.find('.badge').hasClass('bg-primary') ? '1' : '0'
        };
        
        abrirModalEditar(datos);
    });

    // Guardar edición
    $('#btnGuardarEdicion').on('click', function() {
        guardarEdicion();
    });
}

// ========== MOSTRAR RESULTADO DEL REGISTRO ==========
function mostrarResultado(exito, mensaje) {
    const seccionResultado = $('#resultado');
    const iconoResultado = $('#iconoResultado');
    const tituloResultado = $('#tituloResultado');
    const mensajeResultado = $('#mensajeResultado');

    // Ocultar formulario
    $('#registro').addClass('d-none');
    
    // Configurar resultado
    if (exito) {
        iconoResultado.html('<i class="fas fa-check-circle icono-exito"></i>');
        tituloResultado.text('¡Registro Exitoso!');
        tituloResultado.addClass('text-success');
    } else {
        iconoResultado.html('<i class="fas fa-times-circle icono-error"></i>');
        tituloResultado.text('Error en el Registro');
        tituloResultado.addClass('text-danger');
    }
    
    mensajeResultado.text(mensaje);
    seccionResultado.removeClass('d-none');
    
    // Scroll a resultado
    $('html, body').animate({
        scrollTop: seccionResultado.offset().top - 70
    }, 800);
}

// ========== ELIMINAR PARTICIPANTE ==========
function eliminarParticipante(id, fila) {
    // Aquí va la petición AJAX a Laravel
    $.ajax({
        url: `/participantes/${id}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Eliminar fila de la tabla
            const tabla = $('#tablaParticipantes').DataTable();
            tabla.row(fila).remove().draw();
            
            // Mostrar mensaje de éxito
            mostrarAlerta('Participante eliminado correctamente', 'success');
        },
        error: function(error) {
            mostrarAlerta('Error al eliminar el participante', 'danger');
        }
    });
}

// ========== ABRIR MODAL DE EDICIÓN ==========
function abrirModalEditar(datos) {
    $('#editId').val(datos.id);
    $('#editNombre').val(datos.nombre);
    $('#editTelefono').val(datos.telefono);
    $('#editCorreo').val(datos.correo);
    $('#editPonente').val(datos.es_ponente);
    
    const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
    modal.show();
}

// ========== GUARDAR EDICIÓN ==========
function guardarEdicion() {
    const id = $('#editId').val();
    const datos = {
        nombre: $('#editNombre').val(),
        telefono: $('#editTelefono').val(),
        correo: $('#editCorreo').val(),
        es_ponente: $('#editPonente').val()
    };

    // Validación básica
    if (!datos.nombre || !datos.telefono || !datos.correo) {
        mostrarAlerta('Por favor complete todos los campos', 'warning');
        return;
    }

    // Aquí va la petición AJAX a Laravel
    $.ajax({
        url: `/participantes/${id}`,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: datos,
        success: function(response) {
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
            
            // Actualizar tabla
            actualizarFilaTabla(id, datos);
            
            // Mostrar mensaje de éxito
            mostrarAlerta('Participante actualizado correctamente', 'success');
        },
        error: function(error) {
            mostrarAlerta('Error al actualizar el participante', 'danger');
        }
    });
}

// ========== ACTUALIZAR FILA DE LA TABLA ==========
function actualizarFilaTabla(id, datos) {
    const tabla = $('#tablaParticipantes').DataTable();
    const fila = $(`button[data-id="${id}"]`).closest('tr');
    
    // Actualizar datos
    const celdas = fila.find('td');
    celdas.eq(0).text(datos.nombre);
    celdas.eq(1).text(datos.telefono);
    celdas.eq(2).text(datos.correo);
    
    // Actualizar badge
    const badgeClass = datos.es_ponente === '1' ? 'bg-primary' : 'bg-dark';
    const badgeText = datos.es_ponente === '1' ? 'Ponente' : 'Participante';
    celdas.eq(3).html(`<span class="badge ${badgeClass}">${badgeText}</span>`);
    
    tabla.draw(false);
}

// ========== MOSTRAR ALERTAS ==========
function mostrarAlerta(mensaje, tipo) {
    const alerta = `
        <div class="alert alert-${tipo} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" 
             role="alert" style="z-index: 9999; min-width: 300px;">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alerta);
    
    // Auto-ocultar después de 3 segundos
    setTimeout(function() {
        $('.alert').fadeOut(function() {
            $(this).remove();
        });
    }, 3000);
}

// ========== VALIDACIÓN DE FORMULARIO (Cliente) ==========
function validarFormulario(formulario) {
    const nombre = formulario.find('#nombre').val().trim();
    const telefono = formulario.find('#telefono').val().trim();
    const correo = formulario.find('#correo').val().trim();
    const esPonente = formulario.find('#es_ponente').val();

    // Validar nombre
    if (nombre.length < 3) {
        mostrarAlerta('El nombre debe tener al menos 3 caracteres', 'warning');
        return false;
    }

    // Validar teléfono (formato básico)
    const telefonoRegex = /^[0-9\-\s()]+$/;
    if (!telefonoRegex.test(telefono)) {
        mostrarAlerta('El teléfono debe contener solo números', 'warning');
        return false;
    }

    // Validar correo
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!correoRegex.test(correo)) {
        mostrarAlerta('Ingrese un correo electrónico válido', 'warning');
        return false;
    }

    // Validar selección de tipo
    if (!esPonente) {
        mostrarAlerta('Debe seleccionar el tipo de participación', 'warning');
        return false;
    }

    return true;
}

// ========== LIMPIAR FORMULARIO ==========
function limpiarFormulario() {
    $('#registroForm')[0].reset();
    $('#registroForm .form-control').removeClass('is-invalid is-valid');
}

// ========== AGREGAR PARTICIPANTE A LA TABLA (Demo) ==========
function agregarParticipanteTabla(participante) {
    const tabla = $('#tablaParticipantes').DataTable();
    const badgeClass = participante.es_ponente === '1' ? 'bg-primary' : 'bg-dark';
    const badgeText = participante.es_ponente === '1' ? 'Ponente' : 'Participante';
    
    tabla.row.add([
        participante.nombre,
        participante.telefono,
        participante.correo,
        `<span class="badge ${badgeClass}">${badgeText}</span>`,
        `
            <button class="btn btn-sm btn-warning" data-id="${participante.id}" title="Editar">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" data-id="${participante.id}" title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        `
    ]).draw();
}

// ========== ANIMACIONES DE ENTRADA ==========
function animarEntrada() {
    $('.card').each(function(index) {
        $(this).css('opacity', '0');
        $(this).animate({
            opacity: 1
        }, 500 + (index * 100));
    });
}

// Ejecutar animaciones al cargar
animarEntrada();

// ========== PREVENIR DOBLE ENVÍO ==========
let enviandoFormulario = false;

$('#registroForm').on('submit', function(e) {
    if (enviandoFormulario) {
        e.preventDefault();
        return false;
    }
    
    if (validarFormulario($(this))) {
        enviandoFormulario = true;
        $(this).find('button[type="submit"]').prop('disabled', true).html(
            '<i class="fas fa-spinner fa-spin me-2"></i>Registrando...'
        );
    } else {
        e.preventDefault();
    }
});

// ========== NAVEGACIÓN ACTIVA ==========
$(window).on('scroll', function() {
    const scrollPos = $(window).scrollTop();
    
    $('.nav-link').each(function() {
        const currLink = $(this);
        const refElement = $(currLink.attr('href'));
        
        if (refElement.length && refElement.position().top - 100 <= scrollPos && 
            refElement.position().top + refElement.height() > scrollPos) {
            $('.nav-link').removeClass('active');
            currLink.addClass('active');
        }
    });
});