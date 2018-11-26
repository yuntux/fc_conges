			<div id="bloc_donnees">
<script>
$(function(){
    var URL = " https://conges.fontaine-consultants.fr/api_server/v1/dispatcher.php?&auth_token=<?php echo $_SESSION['mon_token']?>";
    var URL_PROJET = URL + "&object=Projet";
    var URL_CONSULTANT = URL + "&object=Consultant";
    var URL_PARTENAIRE = URL + "&object=Partenaire";
    var URL_LIGNE_STAFFING = URL + "&object=LigneStaffing";

    var projetStore = new DevExpress.data.CustomStore({
        key: "ID_PROJET",
	loadMode: "raw",
        load: function() {
            return sendRequest(URL_PROJET + "&method=get_list");
        },
       insert: function(values) {
		var tab = JSON.stringify(Array(JSON.stringify(values)));
		alert(tab);
		target = URL_PROJET + "&method=add&args=" + "&args_array="+encodeURI(btoa(tab));
		alert(target)
            	res = sendRequest(target);
		//alert(JSON.parse(res));
		//return res;
        },
        update: function(key, values) {
		var tab = JSON.stringify(Array(key, JSON.stringify(values)));
		alert(tab);
		target = URL_PROJET + "&method=update&args=" + "&args_array="+encodeURI(btoa(tab));
		alert(target)
            	res = sendRequest(target);
        },/*
        remove: function(key) {
            return sendRequest(URL + "/DeleteOrder", "DELETE", {
                key: key
            });
        }*/
    });



    var consultantStore = new DevExpress.data.CustomStore({
        key: "ID_CONSULTANT",
	loadMode: "raw",
        load: function() {
            return sendRequest(URL_CONSULTANT + "&method=get_list");
        },
    });

    var partenaireStore = new DevExpress.data.CustomStore({
        key: "ID_PARTENAIRE",
	loadMode: "raw",
        load: function() {
            return sendRequest(URL_PARTENAIRE + "&method=get_list");
        },
    });

    var forecastStore = new DevExpress.data.CustomStore({
        key: "ID_LIGNE_STAFFING",
	loadMode: "raw",
        load: function() {
            return sendRequest(URL_LIGNE_STAFFING + "&method=get_forecast");
        },
        insert: function(values) {
                var tab = JSON.stringify(Array(JSON.stringify(values)));
                alert(tab);
                target = URL_LIGNE_STAFFING + "&method=add_staffing&args=" + "&args_array="+encodeURI(btoa(tab));
                alert(target)
                res = sendRequest(target);
        },
        update: function(key, values) {
                var tab = JSON.stringify(Array(key, JSON.stringify(values)));
                alert(tab);
                target = URL_LIGNE_STAFFING + "&method=change_staffing&args=" + "&args_array="+encodeURI(btoa(tab));
                alert(target)
                res = sendRequest(target);
        },
    });

var VAL_TYPE_PROJET = [{
    "ID": "AC",
    "Name": "Accord cadre"
},{
    "ID": "PR",
    "Name": "Projet"
}];

 
var VAL_STATUT_PROJET = [{
    "ID": "01",
    "Name": "01 - Projet identifié ou Proposition en cours de rédaction"
},
{
    "ID": "02",
    "Name": "02 - Proposition en closing"
},
{
    "ID": "03",
    "Name": "03 - Accord de principe"
},
{
    "ID": "04",
    "Name": "04 - Commandé"
},
{
    "ID": "05",
    "Name": "02 - Terminé"
},
{
    "ID": "06",
    "Name": "02 - Perdu"
},

];
									

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
                caption: "Consultant",
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

        ]
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

    function sendRequest(url, method, data) {
        var d = $.Deferred();
    
        method = method || "GET";

        logRequest(method, url, data);
    
        $.ajax(url, {
            method: method || "GET",
            data: data,
            cache: false,
            xhrFields: { withCredentials: true }
        }).done(function(result) {
           d.resolve(method === "GET" ? JSON.parse(result):result);
	  //d.resolve(JSON.parse(result));
        }).fail(function(xhr) {
            d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
        });
    
        return d.promise();
    }

    function logRequest(method, url, data) {
        var args = Object.keys(data || {}).map(function(key) {
            return key + "=" + data[key];
        }).join(" ");

        var logList = $("#requests ul"),
            time = DevExpress.localization.formatDate(new Date(), "HH:mm:ss"),
            newItem = $("<li>").text([time, method, url.slice(URL.length), args].join(" "));
        
        logList.prepend(newItem);
    }
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
