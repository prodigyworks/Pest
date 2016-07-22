<?php
	require_once("crud.php");
	require_once("diaryfunctions.php");
	
	class ClientCrud extends Crud {
		
		/* Post header event. */
		public function postHeaderEvent() {
			createDocumentLink();
		}
		
		function postInsertEvent($id) {
			addInitialContract($id);
		}
		
		function postEditScriptEvent() {
?>
			if ($("#contracttype").val() == "B") {
				$("#frequency").attr("readonly", true);
				
			} else if ($("#contracttype").val() == "C") {
				$("#frequency").attr("readonly", true);
				
			} else {
				$("#frequency").attr("readonly", false);
			}
<?php
		}
		
		public function postScriptEvent() {
?>
			function contracttype_onchange() {
				if ($("#contracttype").val() == "B") {
					$("#frequency").val("12");
					$("#frequency").attr("readonly", true);
					
				} else if ($("#contracttype").val() == "C") {
					$("#frequency").val("46");
					$("#frequency").attr("readonly", true);
					
				} else {
					$("#frequency").attr("readonly", false);
				}
			}
					
			function editDocuments(node) {
				viewDocument(node, "addclientdocument.php", node, "clientdocs", "clientid");
			}
			
			function newStarterForm(node) {
				window.open("newstarterreport.php?id=" + node);
			}
<?php			
		}
	}
	
	$crud = new ClientCrud();
	$crud->dialogwidth = 950;
	$crud->title = "Client";
	$crud->table = "{$_SESSION['DB_PREFIX']}client";
	$crud->sql = "SELECT A.*
				  FROM  {$_SESSION['DB_PREFIX']}client A
				  ORDER BY A.name";
	$crud->columns = array(
			array(
				'name'       => 'id',
				'viewname'   => 'uniqueid',
				'length' 	 => 6,
				'showInView' => false,
				'filter'	 => false,
				'bind' 	 	 => false,
				'editable' 	 => false,
				'pk'		 => true,
				'label' 	 => 'ID'
			),
			array(
				'unique'	 => true,
				'name'       => 'name',
				'length' 	 => 30,
				'label' 	 => 'Name'
			),
			array(
				'name'       => 'status',
				'length' 	 => 10,
				'label' 	 => 'Status',
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'L',
							'text'		=> 'Live'
						),
						array(
							'value'		=> 'I',
							'text'		=> 'Inactive'
						)
					)
			),
			array(
				'name'       => 'imageid',
				'type'		 => 'IMAGE',
				'required'   => false,
				'length' 	 => 35,
				'showInView' => false,
				'label' 	 => 'Logo'
			),			
			array(
				'name'       => 'firstname',
				'length' 	 => 15,
				'label' 	 => 'First Name'
			),			
			array(
				'name'       => 'lastname',
				'length' 	 => 15,
				'label' 	 => 'Last Name'
			),			
			array(
				'name'       => 'address',
				'length' 	 => 12,
				'showInView' => false,
				'type'		 => 'BASICTEXTAREA',
				'label' 	 => 'Address'
			),
			array(
				'name'       => 'email',
				'length' 	 => 40,
				'label' 	 => 'Email 1'
			),
			array(
				'name'       => 'email2',
				'length' 	 => 40,
				'required'	 => false,
				'label' 	 => 'Email 2'
			),
			array(
				'name'       => 'telephone',
				'length' 	 => 12,
				'label' 	 => 'Telephone'
			),
			array(
				'name'       => 'mobile',
				'length' 	 => 12,
				'required' 	 => false,
				'label' 	 => 'Mobile'
			),
			array(
				'name'       => 'frequency',
				'length' 	 => 20,
				'label' 	 => 'Frequency'
			),
			array(
				'name'       => 'contracttype',
				'onchange'	 => 'contracttype_onchange',
				'length' 	 => 20,
				'label' 	 => 'Contract Type',
				'type'       => 'COMBO',
				'options'    => array(
						array(
							'value'		=> 'A',
							'text'		=> 'A'
						),
						array(
							'value'		=> 'B',
							'text'		=> 'B'
						),
						array(
							'value'		=> 'C',
							'text'		=> 'C'
						)
					)
			),
			array(
				'name'       => 'startdate',
				'length' 	 => 12,
				'datatype'	 => 'date',
				'required' 	 => false,
				'label' 	 => 'Start Date'
			)
		);
		
	$crud->run();
?>
