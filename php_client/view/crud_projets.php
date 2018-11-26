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
        columns: [
	    { 
                dataField: "NUM_PROJET",
		caption: "N° projet",
		//readOnly:true,
           	// allowUpdating: false,
		validationRules: [{ readOnly:true }],
            },
	    { 
		dataField: "NOM_PROJET",
		caption: "Nom projet",
		validationRules: [{ type: "required" }],
            },
            { 
                dataField: "TYPE_PROJET",
                caption: "Type",
                lookup: {
                    dataSource: VAL_TYPE_PROJET,
                    displayExpr: "Name",
                    valueExpr: "ID"
                }
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
                    dataSource: VAL_STATUT_PROJET,
                    displayExpr: "Name",
                    valueExpr: "ID"
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
		validationRules: [{ type: "required" }],
		visible: false,
            },
            {
                dataField: "PROBA_PROJET",
                caption: "Proba clossing",
		validationRules: [{ type: "required" }],
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
        ]
    }).dxDataGrid("instance");

});
</script>

<body class="dx-viewport">
    <div class="demo-container">
        <div id="grid"></div>
    </div>
</body>
</div>
