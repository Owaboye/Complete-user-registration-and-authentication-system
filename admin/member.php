

        <!-- <div class="card mb-4">
        <div class="card-body">
            DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
            <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
            .
        </div>
    </div> -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Users List
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Pix</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Logged in</th>
                        <th>Created date</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Pix</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Logged in</th>
                        <th>Created date</th>  
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                       

                     foreach($users as $user):   
                    ?>
                    <tr>
                        <td><img style="width: 40px; heght: 40px; border-radius: 50%;" src="assets/images/<?= $user->img ?? 'user.png' ?>" alt=""></td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->role ?></td>
                        <td><?= $user->status ?></td>
                        <td>Last logged in</td>
                        <td><?= $user->created_at ?></td>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    

