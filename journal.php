<?php
$pagename = 'Journals';
require_once 'top.php';
$ro=$con->getEvery('journal');
$row_r=$ro->fetchAll();
?>
				<!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Add to Journal</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Dashboard</a></li>
                            <li class="breadcrumb-item ">Journal</li>
                    
                        </ul>
                       

                    </div>

                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i> Add to Journal</a>
                        </div>
                </div>
                <!-- </div> -->
            </div>
					 
            
            
            <div class="row">
                        
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12" id="crd">
                            <?php
                            echo uniqid('I');
                             $success= $error_count="";
                             $toError=$fromError=$amount_dbError=$amount_cdError=$notEqual="";
                             $Error=array("toError"=>"","fromError"=>"","amount_dbError"=>"","amount_cdError"=>"","notEqual"=>"");
                             $x=uniqid();
                             $y=uniqid();
                            if(isset($_POST['submit_journal'])){
                                $count_db= count($_POST['to']);
                                $count_cd= count($_POST['from']);
                                
                               

                                for($i=0; $i< $count_db; $i++ ){
                                    $datesdb=$con->legal_string($_POST['datedb'][$i]);
                                    $tos=$con->legal_string($_POST['to'][$i]);
                                    $descripdb=$con->legal_string($_POST['descriptiondb'][$i]);
                                    $amountdb=$con->legal_string($_POST['amountdb'][$i]);
                                    $acctdb=$con->legal_string($_POST['accountdb'][$i]);
                                    $typesdb=$con->legal_string($_POST['typedb'][$i]);
                                    $trans_id=$y;

                                    if(array_sum($_POST['amountdb'])==array_sum($_POST['amountcd'])){
                                    $con->Journaldb($trans_id, $descripdb, $amountdb, $typesdb, $datesdb, $acctdb, $tos);
                                    }else{
                                      $Error["toError"] = "<div class='alert btn btn-danger' id='box5'>ERROR! Amount debited must be equal to credit side</div>";
                                    }


                                }

                                for($i=0; $i< $count_cd; $i++ ){
                                    $dates=$con->legal_string($_POST['datecd'][$i]);
                                    $froms=$con->legal_string($_POST['from'][$i]);
                                    $descrip=$con->legal_string($_POST['descriptioncd'][$i]);
                                    $amount=$con->legal_string($_POST['amountcd'][$i]);
                                    $acct=$con->legal_string($_POST['accountcd'][$i]);
                                    $types=$con->legal_string($_POST['typecd'][$i]);
                                    $trans_id=$x;
                                    
                                    if(array_sum($_POST['amountdb'])==array_sum($_POST['amountcd'])){
                                    $con->Journal($trans_id, $descrip, $amount, $types, $dates, $acct, $froms);
                                    }else{
                                        $Error["fromError"] = "<div class='alert btn btn-danger' id='box5'>ERROR! Amount credited must be equal to debit side</div>";
                                      }


                                }

                            }
                            

                            ?>

                            <div class="card dash-widget">
                                <div class="card-header"></div>
                            
                                    <div class="card-body">
                                    
                                        <table class="table table-hover table-striped" style="background-color:white">
                                            <thead>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <th colspan ="3">
                                                    <?php
                                                     echo $Error["toError"]; 
                                                     echo $Error["fromError"];
                                                    ?>
                       
                                                        <h4>ACCOUNT JOURNAL</h4>
                                                <!-- testing array values -->
                                                <?php 
                                                        echo '<pre>';
                                                        print_r($_POST["datedb"]);
                                                        print_r($_POST['to']);
                                                        print_r($_POST['descriptiondb']);
                                                        print_r($_POST['amountdb']);
                                                        print_r($_POST['accountdb']);
                                                        print_r($_POST['typedb']);
                                                        print_r($_POST['trans_id_db']);
                                                        ?>
                                                        <!--  -->
                                                        <?php 
                                                         print_r($_POST["datecd"]);
                                                        print_r($_POST['from']);
                                                        print_r($_POST['descriptioncd']);
                                                        print_r($_POST['amountcd']);
                                                        print_r($_POST['accountcd']);
                                                        print_r($_POST['typecd']);
                                                        print_r($_POST['trans_id_cd']);
                                                        ?>
                                                        
                                                    </th>
                                                    
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <thead>
                                                <th>S/N</th>
                                                <th>Description</th>
                                                <th>Dates</th>
                                                <th>Amount</th>
                                                <th>Types</th>
                                                <th>Acct type</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x=0;
                                                foreach ($row_r as $value) {
                                                    // code...
                                                    echo '
                                                        <tr>
                                                        <td>'.++$x.'</td>
                                                        <td>'.$value['descrip'].'</td>
                                                        <td>'.$value['dates'].'</td>
                                                        <td>'.number_format($value['amount'],2).'</td>
                                                        <td>'.$value['types'].'</td>
                                                        <td>'.$value['acct'].'</td>
                                                        <td><a href="edit_journal?id='.$value['id'].'" target="_blank"><i class="fa fa-edit"></i></td>
                                                        </tr>
                                                    ';
                                                }

                                                ?> 
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <!-- /Page Header -->
                            <!-- Add Department Modal -->
                            <div id="add_department" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Journal</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mx-auto" style="padding:10%;">
                                                <form method="post">
                                                    
                                                            
                                                    <div class="row" id='db'>

                                                            
                                                            <div class=" col-md-2" >
                                                                <input type="date" class="form-control" placeholder="date..." name="datedb[]">
                                                            </div>
                                                        

                                                            <div class=" col-md-2">
                                                                <input type="text"  class="form-control" placeholder="to..." name="to[]">
                                                            </div>


                                                            <div class=" col-md-2">
                                                                <input type="text"  class="form-control" placeholder="description..." name="descriptiondb[]">
                                                            </div>
                                                        
                                                            <div class=" col-md-2" >
                                                                <input type="number"  class="form-control" placeholder="amount..." name="amountdb[]">
                                                            </div>


                                                            <div class=" col-md-2">
                                                            <Select  class="form-control" name="accountdb[]">
                                                                <option disabled selected>db account...</option>
                                                                <?php
                                                                    $get=$con->getAlls('chartofaccount'); 
                                                                    $ro=$get->fetchAll();
                                                                    foreach($ro as $value){   
                                                                    echo '<option>'.$value['acct_name'].'</option>';
                                                                    }
                                                                ?>	
                                                            </select>
                                                            </div>


                                                            <div class=" col-md-2" style="display:none">
                                                                        <input   class="form-control" value="debit" name="typedb[]" >
                                                            </div>

                                                            <div class=" col-md-2" style="display:none">
                                                                        <input   class="form-control" value="<?php echo uniqid('I') ?>" name="trans_id_db[]" >
                                                            </div>
                                                                    

                                                            <div class="col-md-2">
                                                                        <button id="add_db_Rows" type="button" name="add_fields" class="btn btn-warning">+   debit</button>
                                                            </div>
                                                            

                                                            <div id="db_Rows" style="padding:1%;" ></div>

                                                            
                                                                    
                                                    </div>
                                                            
                                            

                                                    <!--  -->
                                                    <hr style="background-color:white;">
                                                    <!--  -->
                                            
                                                    <div class="row" id='cd' style="">

                                                                    
                                                                    <div class=" col-md-2" >
                                                                        <input type="date" class="form-control" placeholder="date" name="datecd[]">
                                                                    </div>

                                                        

                                                                    <div class=" col-md-2">
                                                                        <input type="text"  class="form-control" placeholder="from..." name="from[]">
                                                                    </div>


                                                                    <div class=" col-md-2">
                                                                        <input type="text"  class="form-control" placeholder="description..." name="descriptioncd[]">
                                                                    </div>
                                                                
                                                                    <div class=" col-md-2" >
                                                                        <input type="number"  class="form-control" placeholder="amount" name="amountcd[]">
                                                                    </div>

                                                                    
                                                                    <div class="col-md-2">
                                                                        <select type="text"  class="form-control" placeholder="cd account" name="accountcd[]">
                                                                            <option disabled selected>cd Account...</option>
                                                                            <?php
                                                                                $get=$con->getAlls('chartofaccount'); 
                                                                                $ro=$get->fetchAll();
                                                                                foreach($ro as $value){   
                                                                                echo '<option>'.$value['acct_name'].'</option>';
                                                                                }
                                                                            ?>	
                                                                        </select>
                                                                    </div>


                                                                    <div class=" col-md-2" style="display:none;" >
                                                                        <input  class="form-control" value="credit" name="typecd[]">
                                                                    </div>
                                                                    <!-- this unique id is not used because it doesent generate the id 
                                                                by group so it is not necessary and can be removed -->
                                                                    <div class=" col-md-2" style="display:none">
                                                                        <input   class="form-control" value="<?php echo uniqid('I') ?>" name="trans_id_cd[]" >
                                                                     </div>

                                                                    <div class=" col-md-2">
                                                                    <button id="add_cd_Rows" type="button" name="add_fields" class="btn btn-warning">+ Credit</button>
                                                                    </div>
                                                                    

                                                                    <div id="cd_Rows" style="padding:1%;" ></div>
                                        
                                                            
                                                    </div>
                                                                
                                                    <div class="mx-auto">
                                                        <button id="submit_j" type="submit" name="submit_journal" class="btn btn-success" style="width: 850px;">Submit Record</button>
                                                    </div>
                                                
                                                </form>
                                    
                                            </div>                                              
                                        </div>
                                    </div>
                                </div>


                             </div>

        
           




<script type="text/javascript">

var rowCount = 1; 
var php_var = "<?php 
                    $get=$con->getAlls('chartofaccount'); 
                    $ro=$get->fetchAll();
                    foreach($ro as $value){   
                    echo "<option>".$value["acct_name"]."</option>";
                    }
                 ?>";
// these unique id is not used because it doesent generate the id by group so it is not necessary and can be removed
var php_uniq_id_db ="<?php echo uniqid('db'); ?>";
var php_uniq_id_cd ="<?php echo uniqid('cd'); ?>";

$(document).ready(function(){


	/* Add Rows */
	$('#add_db_Rows').click(function(event){
		event.preventDefault();
				
				rowCount++; 
				var recRow_db ='<div id="added_field'+rowCount+'" style="padding:1%;"><div class="row"><div class="col-md-2"><input id="datedb'+rowCount+'" type="date" name="datedb[]"  class="form-control" placeholder="date..." required></div><div class=" col-md-2"><input id="to'+rowCount+'" type="text" name="to[]" class="form-control" placeholder="to..." required></div><div class="col-md-2"><input id="descriptiondb'+rowCount+'" type="text" name="descriptiondb[]" class="form-control" placeholder="description..." required></div><div class="col-md-2" ><input id="amount'+rowCount+'" type="number" name="amountdb[]" class="form-control" placeholder="amount" required></div> <div class="col-md-2"> <select id="accountdb'+rowCount+'" type="text"s name="accountdb[]"  class="form-control" required> <option disabled selected>db Account...</option>'+php_var+'</select></div><div class=" col-md-2" style="display:none"><input id="typedb'+rowCount+'" class="form-control" value="debit" name="typedb[]" ></div><div class="col-md-2"><button id="removeRow'+rowCount+'" type="button" name="add_fields" class="btn btn-danger mt-1" onclick="removeRow('+rowCount+');" >Remove</button></div> <div class=" col-md-2" style="display:none"><input   class="form-control" value="debit" name="type[]" > </div><div class=" col-md-2" style="display:none"><input  id="trans_id_db'+rowCount+'" class="form-control" value="'+php_uniq_id_db+'" name="trans_id_db[]" ></div></div></div>';

				// Appending Div Element
				$('#db_Rows').append(recRow_db);
	});


    $('#add_cd_Rows').click(function(event){
		event.preventDefault();
				
				rowCount++; 
				var recRow_cd ='<div id="added_field1'+rowCount+'" style="padding:1%;"><div class="row"><div class="col-md-2"><input id="datecd'+rowCount+'" type="date" name="datecd[]"  class="form-control" placeholder="date..." required></div><div class=" col-md-2"><input id="from'+rowCount+'" type="text" name="from[]" class="form-control" placeholder="from..." required></div><div class="col-md-2"><input id="descriptioncd'+rowCount+'" type="text" name="descriptioncd[]" class="form-control" placeholder="description" required></div><div class="col-md-2" ><input id="amountcd'+rowCount+'" type="number" name="amountcd[]" class="form-control" placeholder="amount" required></div> <div class="col-md-2"> <select id="accountcd'+rowCount+'" type="text"s name="accountcd[]"  class="form-control"  required><option disabled selected>cd Account...</option>'+php_var+'</select></div><div class="col-md-2" style="display:none;"><input id="typecd'+rowCount+'" class="form-control" value="credit" name="typecd[]"></div><div class="col-md-2"><button id="removeRowz'+rowCount+'" type="button" name="add_field" class="btn btn-danger mt-1" onclick="removeRowz('+rowCount+');" >Remove</button></div> <div class=" col-md-2" style="display:none;" ><input  class="form-control" value="credit" name="type1[]"></div><div class=" col-md-2" style="display:none"><input id="trans_id_cd'+rowCount+'" class="form-control" value="'+php_uniq_id_cd+'" name="trans_id_cd[]" ></div></div></div>';

				// Appending Div Element
				$('#cd_Rows').append(recRow_cd);
	});

		

});

function removeRow(rowNum){
		$('#added_field'+rowNum).remove();
}

function removeRowz(rowNum){
		$('#added_field1'+rowNum).remove();
}




    </script>
<?php
require_once 'footer.php';
?>