<div class="card-header" style="width: 100%; background-color: #1d2736">
    <div class="row" style="width: 100%;">
        <div class="col-12 col-sm-8">
            <h3 class="card-title" style="color: white; font-weight: bold;">NOVEDADES</h3>
        </div>
        <div class="col-12 col-sm-4" style="text-align: right;">
            <button  id="addnovedades" class="btn position-relative">
                Agregar
            </button>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="datagrid">
        <div class="datagrid-item">
            <div class="row">
                <div class="col-12 col-sm-12" style="width: 100%; background: #F5F7F8; padding-top: 10px; padding-bottom: 10px">
                    <div class="row" style="background: #F5F7F8;">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="DateNovedad" id="DateNovedad" class="form-control">
                                        <option value="DiarioNovedad">Diario</option>
                                        <option value="MensualNovedad">Mensual</option>
                                    </select>
                                </div>
                                <div class="col-md-2" id="DiaNovedadContainer">
                                    <select name="DiaNovedad" id="DiaNovedad" class="form-control">
                                    </select>
                                </div>
                                <div class="col-md-3" id="MesGastoContainer">
                                    <select name="MesNovedad" id="MesNovedad" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12" style="width: 100%; padding-top: 15px; margin: 0px;">
                    <div class="row">
                        <div class="col-12 col-sm-12" id="list-novedades">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>

<script>    
    $(document).ready(function() { 
        FechaSelectNovedades()
        document.getElementById('addnovedades').addEventListener('click', function() {
            var formTabsDiv = document.getElementById('form_tabs');
            var formHtml = `
            <form id="form-register-novedades">
                <div class="card-header">
                    <h3 class="card-title">NOVEDADES</h3>
                </div>
                <div class="card-body">
                    <label class="form-label">Controles</label>
                    <div class="form-selectgroup">`;
                        for (var i = 1; i <= 17; i++) {
                            formHtml += `
                            <label class="form-selectgroup-item">
                                <input type="checkbox" name="control" value="Control ${i}" class="form-selectgroup-input" checked>
                                <span class="form-selectgroup-label">${i}</span>
                            </label>`;
                        }
                        formHtml += `
                    </div>
                </div>
                <div class="card-body">
                    <label class="form-label">Llaves</label>
                    <div class="form-selectgroup">`;
                        for (var i = 1; i <= 17; i++) {
                            formHtml += `
                            <label class="form-selectgroup-item">
                                <input type="checkbox" name="llave" value="Llave ${i}" class="form-selectgroup-input" checked>
                                <span class="form-selectgroup-label">${i}</span>
                            </label>`;
                        }
                        formHtml += `
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label class="form-label">Tanque #1</label>
                            <select id="tanque1" class="form-select">
                                <option value="10" >10%</option>
                                <option value="20" >20%</option>
                                <option value="30" >30%</option>
                                <option value="40" >40%</option>
                                <option value="50" >50%</option>
                                <option value="60" >60%</option>
                                <option value="70" >70%</option>
                                <option value="80" >80%</option>
                                <option value="90" >90%</option>
                                <option value="100" >100%</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label">Tanque #2</label>
                            <select id="tanque2" class="form-select">
                                <option value="10" >10%</option>
                                <option value="20" >20%</option>
                                <option value="30" >30%</option>
                                <option value="40" >40%</option>
                                <option value="50" >50%</option>
                                <option value="60" >60%</option>
                                <option value="70" >70%</option>
                                <option value="80" >80%</option>
                                <option value="90" >90%</option>
                                <option value="100" >100%</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label">Tanque #3</label>
                            <select id="tanque3" class="form-select">
                                <option value="10" >10%</option>
                                <option value="20" >20%</option>
                                <option value="30" >30%</option>
                                <option value="40" >40%</option>
                                <option value="50" >50%</option>
                                <option value="60" >60%</option>
                                <option value="70" >70%</option>
                                <option value="80" >80%</option>
                                <option value="90" >90%</option>
                                <option value="100" >100%</option>
                            </select>
                        </div>
                    </div>                    
                </div>
                <div class="card-body">
                    <textarea name="content" id="editor" rows="4"></textarea>
                </div>
                <div class="card-footer">
                    <div class="d-flex" style="text-align: right">
                        <button type="button" class="btn me-auto">CANCELAR</button>
                        <button type="button" class="btn btn-primary" id="btn-registrar-novedades">GUARDAR</button>
                    </div>
                </div>
            </form>
            `;
            formTabsDiv.innerHTML = formHtml;

            let editorInstance;

            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
                toolbar: {
                    items: [
                        'bold', 'italic', 'strikethrough', 'underline',
                        'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'fontSize', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    ],
                    shouldNotGroupWhenFull: true
                },
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                placeholder: 'Escriba sus novedades!',
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                htmlEmbed: {
                    showPreviews: true
                },
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                removePlugins: [
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType',
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents'
                ]
            }).then(editor => {
                editorInstance = editor;
            }).catch(error => {
                console.error(error);
            });


            $('#btn-registrar-novedades').off('click').on('click', function(event) {
                event.preventDefault();
                var controles = [];
                $("input[name='control']:checked").each(function() {
                    controles.push($(this).val());
                });
                var llaves = [];
                $("input[name='llave']:checked").each(function() {
                    llaves.push($(this).val());
                });

                var tanque1 = $("#tanque1").val();
                var tanque2 = $("#tanque2").val();
                var tanque3 = $("#tanque3").val();

                var novedades = editorInstance.getData(); 
                var idCaja = {{ $idcaja }};
                
                var formData = new FormData();
                formData.append('Controles', JSON.stringify(controles));
                formData.append('Llaves', JSON.stringify(llaves)); 
                formData.append('Tanque1', tanque1);
                formData.append('Tanque2', tanque2);
                formData.append('Tanque3', tanque3);
                formData.append('Novedades', novedades); 
                formData.append('idCaja', idCaja); 

                $.ajax({
                    url: '/api/registrar-novedades',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        MostrarMensaje("Creado Exitosamente","success")
                        FiltrarDatosNovedades()
                        CanvasTime()
                    },
                    error: function(error) {
                        console.error('Error al registrar:', error);
                    }
                });
            });

        });


        function MostrarNovedades(response) {
            $('#list-novedades').empty();
            response.libronovedades.forEach(function(novedad) {
                var controles = JSON.parse(novedad.controles);
                var controlesHtml = '';
                for (var i = 1; i <= 17; i++) {
                    var existeControl = controles.some(function(control) {
                        return control.includes(`Control ${i}`);
                    });

                    if (existeControl) {
                        controlesHtml += `<span class="badge badge-outline text-green" style="color:green; margin-bottom: 5px; display: inline-block;">${i}</span> `;
                    } else {
                        controlesHtml += `<span class="badge badge-outline text-red" style="color:red; margin-bottom: 5px; display: inline-block;">${i}</span> `;
                    }
                }
                    

                var llaves = JSON.parse(novedad.llaves);
                var llavesHtml = '';
                for (var i = 1; i <= 17; i++) {
                    var existeLlave = llaves.some(function(llave) {
                        return llave.includes(`Llave ${i}`);
                    });
                    if (existeLlave) {
                        llavesHtml += `<span class="badge badge-outline text-green" style="color:green; margin-bottom: 5px; display: inline-block;">${i}</span> `;
                    } else {
                        llavesHtml += `<span class="badge badge-outline text-red" style="color:red; margin-bottom: 5px; display: inline-block;">${i}</span> `;
                    }
                }

                var card = `
                    <div class="card">
                        <div class="card-header" style="background: #33425B; color: white">
                            <div class="row" style="width: 100%;">
                                <div class="col-md-10">
                                    <h3 class="card-title">${novedad.user.name} - ${novedad.Fecha_registro}</h3>
                                </div>
                                <div class="col-md-2" style="text-align: right">
                                    <span class="badge bg-blue text-blue-fg btn-edit-novedad" data-id="${novedad.id}">Edit</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" style="width: 100%">
                                <div class="col-md-7">
                                    <p>${novedad.detalle}</p>
                                </div>
                                <div class="col-md-5">
                                    <div class="row" style="width: 100%">
                                        <div class="col-md-4">
                                            <p><strong>Tanque #1:</strong> ${novedad.tanque_1}%</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Tanque #2:</strong> ${novedad.tanque_2}%</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><strong>Tanque #3:</strong> ${novedad.tanque_3}%</p>
                                        </div>
                                    </div>
                                    <div class="row" style="width: 100%;">   
                                        <div class="col-md-6">
                                            <label class="form-label">CONTROLES</label>
                                            ${controlesHtml}
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">LLAVES</label>
                                            ${llavesHtml}
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                    </div><br>
                `;

                $('#list-novedades').append(card);
            });
        }

        $(document).on('click', '.btn-edit-novedad', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/api/get-libro-novedades-select/' + id,
                method: 'GET',
                success: function(response) {
                    var controles = JSON.parse(response.controles);
                    var llaves = JSON.parse(response.llaves);

                    var formTabsDiv = document.getElementById('form_tabs');
                    var formHtml = `
                    <form id="form-register-novedades">
                        <div class="card-header">
                            <h3 class="card-title">NOVEDADES</h3>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Controles</label>
                            <div class="form-selectgroup">`;

                    for (var i = 1; i <= 17; i++) {
                        var checked = controles.includes(`Control ${i}`) ? 'checked' : '';
                        formHtml += `
                        <label class="form-selectgroup-item">
                            <input type="checkbox" name="control" value="Control ${i}" class="form-selectgroup-input" ${checked}>
                            <span class="form-selectgroup-label">${i}</span>
                        </label>`;
                    }

                    formHtml += `
                        </div>
                    </div>
                    <div class="card-body">
                        <label class="form-label">Llaves</label>
                        <div class="form-selectgroup">`;

                    for (var i = 1; i <= 17; i++) {
                        var checked = llaves.includes(`Llave ${i}`) ? 'checked' : '';
                        formHtml += `
                        <label class="form-selectgroup-item">
                            <input type="checkbox" name="llave" value="Llave ${i}" class="form-selectgroup-input" ${checked}>
                            <span class="form-selectgroup-label">${i}</span>
                        </label>`;
                    }

                    formHtml += `
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <label class="form-label">Tanque #1</label>
                                <select id="tanque1" class="form-select">
                                    <option value="10" ${response.tanque_1 === '10' ? 'selected' : ''}>10%</option>
                                    <option value="20" ${response.tanque_1 === '20' ? 'selected' : ''}>20%</option>
                                    <option value="30" ${response.tanque_1 === '30' ? 'selected' : ''}>30%</option>
                                    <option value="40" ${response.tanque_1 === '40' ? 'selected' : ''}>40%</option>
                                    <option value="50" ${response.tanque_1 === '50' ? 'selected' : ''}>50%</option>
                                    <option value="60" ${response.tanque_1 === '60' ? 'selected' : ''}>60%</option>
                                    <option value="70" ${response.tanque_1 === '70' ? 'selected' : ''}>70%</option>
                                    <option value="80" ${response.tanque_1 === '80' ? 'selected' : ''}>80%</option>
                                    <option value="90" ${response.tanque_1 === '90' ? 'selected' : ''}>90%</option>
                                    <option value="100" ${response.tanque_1 === '100' ? 'selected' : ''}>100%</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-4">
                                <label class="form-label">Tanque #2</label>
                                <select id="tanque2" class="form-select">
                                    <option value="10" ${response.tanque_2 === '10' ? 'selected' : ''}>10%</option>
                                    <option value="20" ${response.tanque_2 === '20' ? 'selected' : ''}>20%</option>
                                    <option value="30" ${response.tanque_2 === '30' ? 'selected' : ''}>30%</option>
                                    <option value="40" ${response.tanque_2 === '40' ? 'selected' : ''}>40%</option>
                                    <option value="50" ${response.tanque_2 === '50' ? 'selected' : ''}>50%</option>
                                    <option value="60" ${response.tanque_2 === '60' ? 'selected' : ''}>60%</option>
                                    <option value="70" ${response.tanque_2 === '70' ? 'selected' : ''}>70%</option>
                                    <option value="80" ${response.tanque_2 === '80' ? 'selected' : ''}>80%</option>
                                    <option value="90" ${response.tanque_2 === '90' ? 'selected' : ''}>90%</option>
                                    <option value="100" ${response.tanque_2 === '100' ? 'selected' : ''}>100%</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-4">
                                <label class="form-label">Tanque #3</label>
                                <select id="tanque3" class="form-select">
                                    <option value="10" ${response.tanque_3 === '10' ? 'selected' : ''}>10%</option>
                                    <option value="20" ${response.tanque_3 === '20' ? 'selected' : ''}>20%</option>
                                    <option value="30" ${response.tanque_3 === '30' ? 'selected' : ''}>30%</option>
                                    <option value="40" ${response.tanque_3 === '40' ? 'selected' : ''}>40%</option>
                                    <option value="50" ${response.tanque_3 === '50' ? 'selected' : ''}>50%</option>
                                    <option value="60" ${response.tanque_3 === '60' ? 'selected' : ''}>60%</option>
                                    <option value="70" ${response.tanque_3 === '70' ? 'selected' : ''}>70%</option>
                                    <option value="80" ${response.tanque_3 === '80' ? 'selected' : ''}>80%</option>
                                    <option value="90" ${response.tanque_3 === '90' ? 'selected' : ''}>90%</option>
                                    <option value="100" ${response.tanque_3 === '100' ? 'selected' : ''}>100%</option>
                                </select>
                            </div>
                        </div>                    
                    </div>
                    <div class="card-body">
                        <textarea name="content" id="UpdateEditor" rows="4">${response.detalle}</textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex" style="text-align: right">
                            <button type="button" class="btn me-auto">CANCELAR</button>
                            <button type="button" class="btn btn-primary" id="btn-actualizar-novedades">GUARDAR</button>
                        </div>
                    </div>
                </form>`;

                    formTabsDiv.innerHTML = formHtml;

                    CKEDITOR.ClassicEditor.create(document.getElementById("UpdateEditor"), {
                        toolbar: {
                            items: [
                                'bold', 'italic', 'strikethrough', 'underline',
                                'numberedList', 'todoList', '|',
                                'outdent', 'indent', '|',
                                'fontSize', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        list: {
                            properties: {
                                styles: true,
                                startIndex: true,
                                reversed: true
                            }
                        },
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                            ]
                        },
                        placeholder: 'Escriba sus novedades!',
                        fontFamily: {
                            options: [
                                'default',
                                'Arial, Helvetica, sans-serif',
                                'Courier New, Courier, monospace',
                                'Georgia, serif',
                                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                                'Tahoma, Geneva, sans-serif',
                                'Times New Roman, Times, serif',
                                'Trebuchet MS, Helvetica, sans-serif',
                                'Verdana, Geneva, sans-serif'
                            ],
                            supportAllValues: true
                        },
                        fontSize: {
                            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                            supportAllValues: true
                        },
                        htmlSupport: {
                            allow: [
                                {
                                    name: /.*/,
                                    attributes: true,
                                    classes: true,
                                    styles: true
                                }
                            ]
                        },
                        htmlEmbed: {
                            showPreviews: true
                        },
                        link: {
                            decorators: {
                                addTargetToExternalLinks: true,
                                defaultProtocol: 'https://',
                                toggleDownloadable: {
                                    mode: 'manual',
                                    label: 'Downloadable',
                                    attributes: {
                                        download: 'file'
                                    }
                                }
                            }
                        },
                        mention: {
                            feeds: [
                                {
                                    marker: '@',
                                    feed: [
                                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                        '@sugar', '@sweet', '@topping', '@wafer'
                                    ],
                                    minimumCharacters: 1
                                }
                            ]
                        },
                        removePlugins: [
                            'CKBox',
                            'CKFinder',
                            'EasyImage',
                            'RealTimeCollaborativeComments',
                            'RealTimeCollaborativeTrackChanges',
                            'RealTimeCollaborativeRevisionHistory',
                            'PresenceList',
                            'Comments',
                            'TrackChanges',
                            'TrackChangesData',
                            'RevisionHistory',
                            'Pagination',
                            'WProofreader',
                            'MathType',
                            'SlashCommand',
                            'Template',
                            'DocumentOutline',
                            'FormatPainter',
                            'TableOfContents'
                        ]
                    }).then(editor => {
                        editorInstance = editor;
                    }).catch(error => {
                        console.error(error);
                    });

                    $('#btn-actualizar-novedades').off('click').on('click', function(event) {
                        event.preventDefault();
                        
                        console.log(id)
                        var controles = [];
                        $("input[name='control']:checked").each(function() {
                            controles.push($(this).val());
                        });
                        var llaves = [];
                        $("input[name='llave']:checked").each(function() {
                            llaves.push($(this).val());
                        });

                        var tanque1 = $("#tanque1").val();
                        var tanque2 = $("#tanque2").val();
                        var tanque3 = $("#tanque3").val();

                        var novedades = editorInstance.getData(); 
                        var idCaja = {{ $idcaja }};
                        
                        var formData = new FormData();
                        formData.append('Controles', JSON.stringify(controles));
                        formData.append('Llaves', JSON.stringify(llaves)); 
                        formData.append('Tanque1', tanque1);
                        formData.append('Tanque2', tanque2);
                        formData.append('Tanque3', tanque3);
                        formData.append('Novedades', novedades); 
                        formData.append('idCaja', idCaja); 
                        formData.append('id', id); 

                        $.ajax({
                            url: '/api/actualizar-novedades',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                MostrarMensaje("Actualizado Exitosamente","success")
                                CanvasTime()
                                FiltrarDatosNovedades()
                            },
                            error: function(error) {
                                console.error('Error al registrar:', error);
                            }
                        });
                    });
                },
                error: function(xhr) {
                    MostrarMensaje("No Puedes Editar, El registro no te pertenece","error")
                    CanvasTime()
                }
            });
        });


        function FechaSelectNovedades() {
            var today = new Date();
            var currentDay = today.getDate();
            var currentMonth = today.getMonth();
            var currentYear = today.getFullYear();
            var monthsOfYear = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            $('#MesNovedad').empty();

            for (var month = 0; month < 12; month++) {
                $('#MesNovedad').append('<option value="' + (month + 1) + '">' + monthsOfYear[month] + '</option>');
            }
            $('#MesNovedad').val(currentMonth + 1);

            function updateDaySelectorNovedad() {
                var selectedMonth = parseInt($('#MesNovedad').val());
                var selectedYear = today.getFullYear();
                var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
                $('#DiaNovedad').empty();
                for (var day = 1; day <= daysInMonth; day++) {
                    $('#DiaNovedad').append('<option value="' + day + '">' + day + '</option>');
                }
                if (currentDay > daysInMonth) {
                    $('#DiaNovedad').val(daysInMonth);
                } else {
                    $('#DiaNovedad').val(currentDay);
                }
            }

            updateDaySelectorNovedad();

            $('#DateNovedad').on('change', function() {
                var selectedValue = $(this).val();
                switch (selectedValue) {
                    case 'DiarioNovedad':
                        $('#DiaNovedadContainer').show();
                        $('#MesGastoContainer').show();
                        break;
                    case 'MensualNovedad':
                        $('#DiaNovedadContainer').hide();
                        $('#MesGastoContainer').show();
                        break;
                    default:
                        $('#DiaNovedadContainer').show();
                        $('#MesGastoContainer').show();
                        break;
                }
                FiltrarDatosNovedades();
            });


            $('#MesNovedad').on('change', function() {
                updateDaySelectorNovedad();
                FiltrarDatosNovedades();
            });

            $('#DiaNovedad').on('change', function() {
                FiltrarDatosNovedades();
            });

            $('#DateNovedad').trigger('change');

        }

        function FiltrarDatosNovedades(){
            var today = new Date();
            var selectedYear = today.getFullYear();
            var tipoFiltro = $('#DateNovedad').val();
            var dia = $('#DiaNovedad').val();
            var mes = $('#MesNovedad').val();
            var anio = selectedYear;

            $.ajax({
                url: '/api/filtrar-datos-novedades',
                method: 'GET',
                data: {
                    tipoFiltro: tipoFiltro,
                    dia: dia,
                    mes: mes,
                    anio: anio,
                },
                success: function(response) {
                    MostrarNovedades(response)
                },
                error: function(error) {
                    console.error('Error al filtrar datos:', error);
                }
            });
        }
        
    });
</script>