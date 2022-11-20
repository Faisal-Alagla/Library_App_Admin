<div class=" mb-3 mt-3 text-start input">
    <label class="form-label" for="category" style="color:#212B5E;">Category</label>
    <select id="category" name="category" class="form-control form-control-lg shadow-lg form-select" style="border-radius: 15px; padding-right: 40px; padding-left: 40px;">
        <option value="">Select Category</option>

        <?php
        //fetching data from the books table
        $ref_table = 'categories';
        $fetch_category = $database->getReference($ref_table)->getValue();

        //displaying table rows
        if ($fetch_category > 0) {
            $num = 1;
            foreach ($fetch_category as $key => $row) {
        ?>

                <option value="<?php echo $row['value'] ?>"><?php echo $row['label'] ?></option>

        <?php
            }
        }
        ?>

    </select>
    <i class="bi bi-tag"></i>
</div>