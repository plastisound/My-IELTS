(function($){

	
		$('#date_start').datepicker();
		$('#date_end').datepicker();

	
		var table = $('#users-list').DataTable( {
			language : {
                sLengthMenu: "Show _MENU_"
            },
            order: [[ 0, "asc" ]],
			responsive: false,
			//iDisplayLength: 40,
			lengthMenu: [[40, 80, 100, -1], [40, 80, 100, "Todo"]],
			//pagingType: "full_numbers",
			bFilter: true,
			language: {
			        lengthMenu:     "Mostrar _MENU_",
				    zeroRecords:    "No se encontraron resultados",
				    emptyTable:     "Ningún dato disponible en esta tabla",
				    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
				    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
			        loadingRecords: "Cargando...",
			        paginate: {
			            first:      "Inicio",
			            previous:   "Anterior",
			            next:       "Siguiente",
			            last:       "Final"
			        },
			        aria: {
			            sortAscending:  ": activer pour trier la colonne par ordre croissant",
			            sortDescending: ": activer pour trier la colonne par ordre dÃ©croissant"
			        }
			    },
        dom: '<"clear">B<"clear">lfrtip',
        	initComplete: function () {
            this.api().columns([4,5]).every( function () {
                var column = this;
                var select = $('<select><option value="">Todos</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                 column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        } , 

             buttons: 
			        [
			        	{
			                extend:    'excelHtml5',
			                text: 'Exportar a Excel',
			                className: 'bckme-xls',
			                exportOptions: { orthogonal: 'export' }
			            },
			            
			        ]
    } );
		// Event listener to the two range filtering inputs to redraw on input
	 
	

		
	
   /* $('#users-list tbody')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        } );*/

})(jQuery);