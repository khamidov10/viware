<div class="row rounded p-3 bg-white">


   <div class='table-responsive'>
<table class="table table-bordered">
        <thead>
            <tr>
                <th>Diller</th>
                <th>Summa</th>
                <th>Sana</th>
                <th>To'langan</th>
                <th>Holati</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $inn = $db->query("SELECT * FROM users WHERE id={$_SESSION['userId']}")->fetch_assoc()['inn'];
            $status = [
              1 => "<b class='text-danger'>To'lanmagan</b>",
              2 => "<b class='text-warning'>Qisman to'langan</b>",
                3 => "<b class='text-success'>To'liq to'langan</b>",

            ];
            $loads = $db->query("SELECT * FROM credit WHERE user=$inn");
            while($load = $loads->fetch_assoc()){

        $user = $db->query("SELECT * FROM users WHERE id='{$load['diller']}'")->fetch_assoc();


                echo "
                <tr>
                    <td>{$user['name']} ({$user['inn']})</td>
                    <td>".number_format($load['summa'], 0, '', ' ')." so'm</td>
                    <td>{$load['date']}</td>
                    <td>".number_format($load['payed'], 0, '', ' ')." so'm </td>
                    <td>{$status[$load['status']]}</td>

                </tr>
                ";
            }

            ?>
        </tbody>
    </table>

   </div>
</div>
