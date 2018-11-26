			<div id="bloc_donnees">
<script>
$(function(){
    <?php include_once("model/data.php"); ?>					

    var dataGrid = $("#grid").dxDataGrid({     
        dataSource: projetStore,
        //repaintChangesOnly: true,
        showBorders: true,
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
            },
	    { 
		dataField: "NOM_PROJET",
		caption: "Nom projet",
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
                dataField: "STATUT_PROJET",
                caption: "Statut",
                lookup: {
                    dataSource: VAL_STATUT_PROJET,
                    displayExpr: "Name",
                    valueExpr: "ID"
                }
            },
	    {
                dataField: "ID_DM_PROJET",
                caption: "DM",
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
        ]
    }).dxDataGrid("instance");



    var forecastGrid = $("#forecastGrid").dxDataGrid({     
        dataSource: forecastStore,
        //repaintChangesOnly: true,
        showBorders: true,
	columnAutoWidth: true,
	columnResizingMode: "nextColumn",
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
            visible: true
        },
        searchPanel: {
            visible: true
        },
        editing: {
            mode: "cell",
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
                dataField: "ID_CONSULTANT_LIGNE_STAFFING",
                caption: "",
		groupIndex: 0,
                lookup: {
                    dataSource: {
                        store: consultantStore, 
                    },
                    valueExpr: "ID_CONSULTANT",
                    displayExpr: "NOM_CONSULTANT"
                }
            },
            {
                dataField: "ID_PROJET_LIGNE_STAFFING",
                caption: "Projet",
                lookup: {
                    dataSource: {
                        store: projetStore, 
                    },
                    valueExpr: "ID_PROJET",
                    displayExpr: "NOM_PROJET"
                }
            },
/*
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
*/
<?php
	$current_year = date('Y');
	$current_month = date('m');
	$nb_mois_futur = 6;
	for ($i = 0; $i <= $nb_mois_futur; $i++){
		$m = str_pad(($current_month + $i)%12, 2, '0', STR_PAD_LEFT);
		$y = $current_year + intval(($current_month + $i)/12);
		//$tmp[$y."-".$m] = 0;
echo '      {
                dataField: "'.$y.'-'.$m.'",
                caption: "'.$y.'-'.$m.'",
            },';
	}
?>

        ],
        summary: {
            groupItems: [{
                column: "ID_PROJECT_LIGNE_STAFFING",
                summaryType: "count",
                displayFormat: "{0} missions",
            },
<?php
        $current_year = date('Y');
        $current_month = date('m');
        $nb_mois_futur = 6;
        for ($i = 0; $i <= $nb_mois_futur; $i++){
                $m = str_pad(($current_month + $i)%12, 2, '0', STR_PAD_LEFT);
                $y = $current_year + intval(($current_month + $i)/12);
                //$tmp[$y."-".$m] = 0;
echo '     {
                column: "'.$y.'-'.$m.'",
		summaryType: "sum",
                alignByColumn: true,
		displayFormat: "{0} jh",
            },';
        }
?>
	    ]
        }
    }).dxDataGrid("instance");



    $("#refresh-mode").dxSelectBox({
        items: ["full", "reshape", "repaint"],
        value: "reshape",
        onValueChanged: function(e) {
            dataGrid.option("editing.refreshMode", e.value);  
        }
    });

    $("#clear").dxButton({
        text: "Clear",
        onClick: function() {
            $("#requests ul").empty();
        }
    });
});
</script>

<body class="dx-viewport">
    <div class="demo-container">
        <div id="grid"></div>
<!--
        <div class="options">
            <div class="caption">Options</div>
            <div class="option">
                <span>Refresh Mode:</span>
                <div id="refresh-mode"></div>
            </div>
            <div id="requests">
                <div>
                    <div class="caption">Network Requests</div>
                    <div id="clear"></div>
                </div>
                <ul></ul>
            </div>
-->
        </div>
        <div id="forecastGrid"></div>
<!--
        <div class="options">
            <div class="caption">Options</div>
            <div class="option">
                <span>Refresh Mode:</span>
                <div id="refresh-mode"></div>
            </div>
            <div id="requests">
                <div>
                    <div class="caption">Network Requests</div>
                    <div id="clear"></div>
                </div>
                <ul></ul>
            </div>
-->
        </div>
    </div>
</body>
</div>
