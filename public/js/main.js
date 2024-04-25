$(document).ready(function () {
  var RegionesYcomunas = {

    "regiones": [{
            "NombreRegion": "Región de Arica y Parinacota",
            "comunas": ["Arica", "Camarones", "Putre", "General Lagos"]
    },
        {
            "NombreRegion": "Región de Tarapacá",
            "comunas": ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
    },
        {
            "NombreRegion": "Región de Antofagasta",
            "comunas": ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
    },
        {
            "NombreRegion": "Región de Atacama",
            "comunas": ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
    },
        {
            "NombreRegion": "Región de Coquimbo",
            "comunas": ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
    },
        {
            "NombreRegion": "Región de Valparaíso",
            "comunas": ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
    },
        {
            "NombreRegion": "Región del Libertador Gral. Bernardo O'Higgins",
            "comunas": ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
    },
        {
            "NombreRegion": "Región del Maule",
            "comunas": ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
    },
        {
            "NombreRegion": "Región del Biobío",
            "comunas": ["Concepción", "Coronel", "Chiguayante", "Florida", "Hualqui", "Lota", "Penco", "San Pedro de la Paz", "Santa Juana", "Talcahuano", "Tomé", "Hualpén", "Lebu", "Arauco", "Cañete", "Contulmo", "Curanilahue", "Los Álamos", "Tirúa", "Los Ángeles", "Antuco", "Cabrero", "Laja", "Mulchén", "Nacimiento", "Negrete", "Quilaco", "Quilleco", "San Rosendo", "Santa Bárbara", "Tucapel", "Yumbel", "Alto Biobío", "Chillán", "Bulnes", "Cobquecura", "Coelemu", "Coihueco", "Chillán Viejo", "El Carmen", "Ninhue", "Ñiquén", "Pemuco", "Pinto", "Portezuelo", "Quillón", "Quirihue", "Ránquil", "San Carlos", "San Fabián", "San Ignacio", "San Nicolás", "Treguaco", "Yungay"]
    },
        {
            "NombreRegion": "Región de la Araucanía",
            "comunas": ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
    },
        {
            "NombreRegion": "Región de Los Ríos",
            "comunas": ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
    },
        {
            "NombreRegion": "Región de Los Lagos",
            "comunas": ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
    },
        {
            "NombreRegion": "Región Aisén del Gral. Carlos Ibáñez del Campo",
            "comunas": ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
    },
        {
            "NombreRegion": "Región de Magallanes y de la Antártica Chilena",
            "comunas": ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
    },
        {
            "NombreRegion": "Región Metropolitana de Santiago",
            "comunas": ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Vitacura", "Puente Alto", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilVl", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor", "Santiago"]
    }]
    }
    var iRegion = 0;
    var htmlRegion = '<option value="sin-region">Seleccione Región</option>';
    var htmlComunas = '<option value="sin-region">Seleccione Comuna</option>';
    var valorRegionOriginal = jQuery('#region').val();
    jQuery.each(RegionesYcomunas.regiones, function () {
        htmlRegion = htmlRegion + '<option value="' + RegionesYcomunas.regiones[iRegion].NombreRegion + '"' +
                      (RegionesYcomunas.regiones[iRegion].NombreRegion.trim().toLowerCase() === valorRegionOriginal.trim().toLowerCase() ? 'selected' : '') +
                      '>' + RegionesYcomunas.regiones[iRegion].NombreRegion + '</option>';
    iRegion++;
    });

    jQuery('#region').html(htmlRegion);
    //jQuery('#comuna').html(htmlComunas);
    jQuery('#busc_region').html(htmlRegion);
    jQuery('#busc_comu').html(htmlComunas);

    jQuery('#region').on('change', function () {
        var iRegiones = 0;
        var valorRegion = jQuery(this).val();
        var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option>';
        jQuery.each(RegionesYcomunas.regiones, function () {
            if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
                var iComunas = 0;
                jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
                    htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
                    iComunas++;
                });
            }
            iRegiones++;
        });
        jQuery('#comuna').html(htmlComuna);
    });
    jQuery('#busc_region').change(function () {
      var iRegiones = 0;
      var valorRegion = jQuery(this).val();
      var htmlComuna = '<option value="sin-comuna">Seleccione comuna</option>';
      jQuery.each(RegionesYcomunas.regiones, function () {
          if (RegionesYcomunas.regiones[iRegiones].NombreRegion == valorRegion) {
              var iComunas = 0;
              jQuery.each(RegionesYcomunas.regiones[iRegiones].comunas, function () {
                  htmlComuna = htmlComuna + '<option value="' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '">' + RegionesYcomunas.regiones[iRegiones].comunas[iComunas] + '</option>';
                  iComunas++;
              });
          }
          iRegiones++;
      });
      jQuery('#busc_comu').html(htmlComuna);
  });
    jQuery('#comuna').change(function () {
        if (jQuery(this).val() == 'sin-region') {
            alert('selecciones Región');
        } else if (jQuery(this).val() == 'sin-comuna') {
            alert('selecciones Comuna');
        }
    });
    jQuery('#region').change(function () {
        if (jQuery(this).val() == 'sin-region') {
            alert('seleccione Región');
        }
    });
    
    jQuery('#busc_region').change(function () {
      if (jQuery(this).val() == 'sin-region') {
          alert('Seleccione Región');
          location.reload()
      }
    });
    jQuery('#busc_comu').change(function () {
        if (jQuery(this).val() == 'sin-region') {
            alert('Seleccione Región');
            location.reload()
        } else if (jQuery(this).val() == 'sin-comuna') {
            alert('Seleccione Comunas');
            location.reload()
        }
    });
    jQuery('#region').val(valorRegionOriginal);
    
  window._token = $('meta[name="csrf-token"]').attr('content')

  moment.updateLocale('en', {
    week: {dow: 1} // Monday is the first day of the week
  })

  $('.date').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    locale: 'en',
    sideBySide: true,
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.timepicker').datetimepicker({
    format: 'HH:mm:ss',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2()

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  })

  $('.c-header-toggler.mfs-3.d-md-down-none').click(function (e) {
    $('#sidebar').toggleClass('c-sidebar-lg-show');

    setTimeout(function () {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    }, 400);
  });

    // Tu código aquí dentro
    
    function formatearYValidarRutInput(rut) {
      rut = rut.replace(/[^\dkK]+/g, '');
      
      if (rut.length < 2) {
      // RUT inválido, mostrar mensaje de error o realizar alguna acción
      return;
      }
      
      var dv = rut.charAt(rut.length - 1);
      var rutNumeros = rut.slice(0, -1);
      
      // Verificar si rutNumeros es '0' después de quitar el guion
      if (rutNumeros === '0') {
      // Manejar el caso especial donde el RUT es '-0'
      rut = '';
      return rut;
      }
      
      rutNumeros = rutNumeros.padStart(8, '0');
      
      if (isNaN(rutNumeros)) {
      // RUT inválido, mostrar mensaje de error o realizar alguna acción
      rut = '';
      return rut;
      }
      
      var suma = 0;
      var factor = 2;
      
      for (var i = rutNumeros.toString().length - 1; i >= 0; i--) {
      suma += factor * rutNumeros.toString().charAt(i);
      
      factor++;
      if (factor > 7) {
        factor = 2;
      }
      }
      
      var dvEsperado = 11 - (suma % 11);
      dvEsperado = (dvEsperado === 11) ? 0 : ((dvEsperado === 10) ? 'K' : dvEsperado.toString());
      
      // Corregir la comparación del dígito verificador
      if (dv.toString().toUpperCase() !== dvEsperado.toString().toUpperCase()) {
      // RUT inválido, mostrar mensaje de error o realizar alguna acción
      rut = '';
      return rut;
      }
      
      var rutTotal = rutNumeros + dvEsperado;
      rut = rutTotal.toString().replace(/^(\d{1,2})(\d{3})(\d{3})([\dkK0-9]{1})$/, "$1.$2.$3-$4");
      
      return rut;
    }
    
    jQuery('#rut').on('blur', function() {
        var rut = jQuery(this).val();
        var rutFormateado = formatearYValidarRutInput(rut);

        if(rutFormateado == 0 || rutFormateado == "" || rutFormateado == "NaN"){
            jQuery(this).addClass("error");
            jQuery(this).val(rutFormateado);
            alert("El rut no es Válido.");
        }else{
            jQuery(this).val(rutFormateado);
            jQuery(this).removeClass("error");
        }
    });
});
