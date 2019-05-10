			<div id="bloc_donnees">
<script>
$(function(){
    <?php include_once("model/data.php"); ?>					

    var dataGrid = $("#grid").dxDataGrid({     
        dataSource: projetStore,
        //repaintChangesOnly: true,
        showBorders: true,
	columnAutoWidth: true,
	columnHidingEnabled: true,
	columnResizingMode: "nextColumn",
        "export": {
            enabled: true,
            fileName: "Employees",
            allowExportSelectedData: true
        },
        filterRow: {
            visible: true,
            applyFilter: "auto"
        },
        headerFilter: {
            visible: true
        },
        columnChooser: {
            enabled: true
        },
        columnFixing: { 
            enabled: true
        },
        stateStoring: {
            enabled: true,
            type: "localStorage",
            storageKey: "storage_staffing"
        },
	grouping: {
            autoExpandAll: true,
        },
        groupPanel: {
            visible: true,
	    emptyPanelText: "Use the context menu of header columns to group data",
        },
        searchPanel: {
            visible: true
        },
	/*
        editing: {
            refreshMode: "reshape",
            mode: "cell",
            allowAdding: true,
            allowUpdating: true,
            allowDeleting: true
        },*/
        editing: {
            mode: "form",
            form: {
                labelLocation: "left",
		colCount: 5,
            },
refreshMode: "full",
            allowAdding: true,
            allowUpdating: true,
            allowDeleting: false,
/*
            popup: {
                title: "Info",
                showTitle: true,
                width: 900,
                height: 600,
                position: {
                    my: "top",
                    at: "top",
                    of: window
                }
            }
*/
        },
        scrolling: {
            mode: "virtual"
        },
	columnFixing: { 
        	    enabled: true
        },
	rowAlternationEnabled: true,
        allowColumnResizing: true,
        showBorders: true,
        columnResizingMode: "nextColumn",
        columnMinWidth: 50,
        columnAutoWidth: true,
        columns: [
	    { 
                dataField: "NUM_PROJET",
		caption: "N° projet",
		//readOnly:true,
           	// allowUpdating: false,
		//validationRules: [{ readOnly:true }],
           	width: 75,
            	fixed: true,
		formItem: {
			colSpan: 1,
			/*label: {
			    location: "top"
			},*/
			editorOptions: {
                		disabled: true
            		},
		}
            },
	    { 
		dataField: "NOM_PROJET",
		caption: "Nom projet",
		validationRules: [{ type: "required" }],
		formItem: {
			colSpan: 3,
		}
            },
            { 
                dataField: "TYPE_PROJET",
                caption: "Type",
                lookup: {
                    dataSource: {
                        store: typeProjetStore, 
                    },
                    valueExpr: "CODE_TYPE_PROJET",
                    //diplayExpr: "CODE_TYPE_PROJET",
                    displayExpr: "LIBELLE_TYPE_PROJET"
                },
            },
            { 
                dataField: "IS_ACCORD_CADRE_PROJET",
                caption: "AC",
		dataType: "boolean",
            },
            { 
                dataField: "STATUT_PROJET",
                caption: "Statut",
		validationRules: [{ type: "required" }],
                lookup: {
                    dataSource: {
                        store: typeProjetStore, 
                    },
                    valueExpr: "CODE_STATUT_PROJET",
                    displayExpr: "LIBELLE_STATUT_PROJET"
                },
		formItem: {
			colSpan: 2,
		}
            },
	    {
                dataField: "ID_DM_PROJET",
                caption: "DM",
		validationRules: [{ type: "required" }],
                lookup: {
                    dataSource: {
                        store: consultantStore, 
			filter: [ "PROFIL_CONSULTANT", "<>", "CONSULTANT" ]
                    },
                    valueExpr: "ID_CONSULTANT",
                    displayExpr: "NOM_CONSULTANT"
                },
		formItem: {
			colSpan: 2,
		}
            },
            {
                dataField: "ID_CLIENT_PROJET",
                caption: "Client",
                lookup: {
                    dataSource: {
                        store: partenaireStore, 
                        //filter: [ "PROFIL_CONSULTANT", "<>", "CONSULTANT" ]
                    },
                    valueExpr: "ID_PARTENAIRE",
                    displayExpr: "NOM_PARTENAIRE"
                }
            },
            {
                dataField: "CLIENT_SAISIE_LIBRE_PROJET",
                caption: "Client (saisie libre)",
            },
            {
                dataField: "COMMANDITAIRE_PROJET",
                caption: "Commanditaire",
            },
            {
                dataField: "CA_PROJET",
                caption: "CA prévisionnel",
		visible: false,
            },
            {
                dataField: "PROBA_PROJET",
                caption: "Proba clossing",
		visible: false,
            },
            {
                dataField: "COMMENTAIRE_PROJET",
                caption: "Commentaire",
            },
            {
                dataField: "SOUS_TRAITANT_PROJET",
                caption: "Sous traitant",
		visible: false,
            },
            {
                dataField: "CA_SOUS_TRAITANT_PROJET",
                caption: "CA sous-traitance",
		visible: false,
            },
            { 
                dataField: "IS_PAIEMENT_DIRECT_PROJET",
                caption: "P.D.",
		dataType: "boolean",
            },
        ],
/*
        selection: {
            mode: "single"
        },
        masterDetail: {
            enabled: true,
            template: function(container, options) { 
                var currentEmployeeData = options.data;
                container.append($('<div class="employeeInfo"><img class="employeePhoto" src="' + currentEmployeeData.Picture + '" /><p class="employeeNotes">' + currentEmployeeData.Notes + '</p></div>'));
            }
        }
*/
    }).dxDataGrid("instance");

});
</script>

<body class="dx-viewport">
    <div class="demo-container">
        <div id="grid"></div>
    </div>
</body>
</div>
