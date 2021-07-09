<?php 
include '../../config.php';
$listUser = selectFromDB($conn,"user",array());
$listRole = array("ADMIN","USER");

?>
<div class="row">
    <div class="col-md-12">
        <!-- <h4>User Management</h4> -->
        <button class="btn btn-primary " id="addUserBtn" data-toggle="modal"
            data-target="#modalUser">Tambah</button>
        <br>
        <br>

        <div class="modal fade" id="modalUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User Management</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="api.php" method="POST" id="userManagementForm">
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Username</label>
                                <input type="text" class="form-control" id="userName_field"
                                    name="username_field" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName_field"
                                    name="fullname_field" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Password</label>
                                <input type="password" class="form-control" id="password_field" name="password_field"
                                    placeholder="Password">
                            </div>                         
                            

                            <div class="form-group">
                                <label>Role</label>
                                <select name="role_field" id="role_field" class="form-control ticketFieldMain">
                                    <?php foreach ($listRole as $key => $value) { ?>
                                        <option value="<?=$value?>"><?=$value?></option>
                                    <?php }?>
                                </select>
                            </div>

                            
                            
                            <input type="hidden" id="opUser" name="op" value="addUser">
                            <input type="hidden" name="url" value="user">
                            <input type="hidden" name="id_user" id="userId" value="">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary ">Save</button>
                        </form>
                    </div>
                    
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
       
        <table class="table table-bordered formatHTML5" id="userTable">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    
                    
                    <th>Edit</th>
                    <!-- <th>Delete</th> -->
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($listUser as $key => $value) { ?>
                <tr>
                    <td><?=$value['username']?></td>
                    <td><?=$value['fullname']?></td>
                    <td><?=$value['role']?></td>
                    
                    
                    <td><button data-toggle="modal" data-target="#modalUser"
                            class="btn btn-primary  editUser" userName="<?=$value['username']?>" fullName="<?=$value['fullname']?>"
                            role="<?=$value['role']?>" department="<?=$value['department']?>" id="<?=$value['id']?>">Edit</button></td>
                    
                </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        <?php
            if(isset($_GET['error'])){
                echo "alert('username already exist');";
            }
        ?>
        $(".department").hide();
        $("#role_field").change(function(){
            var choice = $(this).val();
            if(choice=="department"){
                $(".department").show();
            }else{
                $(".department").hide();
            }
        });
        $(".editUser").click(function(){
            $("#userName_field").val($(this).attr("userName"));
            $("#fullName_field").val($(this).attr("fullName"));
            $("#userId").val($(this).attr("id"));
            $("#role_field").val($(this).attr("role"));
            $("#department_field").val($(this).attr("department"));
            if($(this).attr("role")!="department"){
                $(".department").hide();
            }else{
                $(".department").show();
            }
            $("#email_field").val($(this).attr("email"));
            $("#opUser").val('editUser');
        });
        $("#addUserBtn").click(function(){
            $(".department").hide();
            $('#userManagementForm').trigger("reset");
            $("#opUser").val('addUser');
        });
    });
</script>