<div class="container">
    <div class="row">
        <!-- Column 1 -->
        <div class="col-md-4">
            <div class="form-group">
                <label for="med_name">Jina la Dawa:</label>
                <input type="text" class="form-control" name="med_name" id="med_name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="category">Aina ya Dawa:</label>
                <select class="form-control" name="category" required>
                    <option value="">Chagua aina ya Dawa</option>
                    <option value="mbao">Mbao</option>
                    <option value="miti">Miti</option>
                    <option value="Gesi">Gesi</option>
                    <option value="tissue">Tishu</option>
                    <option value="soda">Soda</option>
                    <option value="juisi">Juisi</option>
                    <option value="bia">Bia</option>
                    <option value="maji">Maji</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="company">Msambazaji:</label>
                <input type="text" class="form-control" name="company" id="company" required>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="quantity">Idadi:</label>
                <input type="number" class="form-control" name="quantity" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="sell_type">kipimo cha kuuza:</label>
                <select class="form-control" name="sell_type">
                    <option value="pc">pc</option>
                    <option value="chupa">chupa</option>
                    <option value="kreti">kreti</option>
                    <option value="kotoni">kotoni</option>
                    <option value="roll">roll</option>
                    <option value="box">box</option>
                    <option value="kg">kg</option>
                    <option value="bags">bags</option>
                    <option value="mm">mm</option>
                    <option value="Kopo">Kopo</option>
                    <option value="Lita">Lita</option>
                    <option value="Sewa">Sewa</option>
                    <option value="pkt">pkt</option>
                    <option value="trip">trip</option>
                    <option value="1/4kg">1/4kg</option>
                    <option value="ndoo">ndoo</option>
                    <option value="m">m</option>
                    <option value="nr">nr</option>
                    <option value="kopo">kopo</option>
                    <option value="gln">gln</option>
                    <option value="m3">m3</option>
                    <option value="nr">nr</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="reg_date">Tarehe ya kusajiriwa:</label>
                <input type="date" class="form-control" name="reg_date" id="reg_date" required>
            </div>
        </div>
    </div>

    <!-- Third Row -->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exp_date">Tarehe ku expire:</label>
                <input type="date" class="form-control" name="exp_date" id="exp_date" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="stock_alert">Idadi tahadhari kuisha Dawa:</label>
                <input type="text" class="form-control" name="stock_alert" id="stock_alert" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="actual_price">Bei kununulia:</label>
                <input type="number" class="form-control" name="actual_price" id="actual_price" required>
            </div>
        </div>
    </div>

    <!-- Fourth Row -->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="selling_price">Bei kuuza:</label>
                <input type="number" class="form-control" name="selling_price" id="selling_price" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="profit_price">Faida:</label>
                <input type="text" class="form-control" name="profit_price" id="profit_price" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="created_by">Anayerekodi ni:</label>
                <input type="text" class="form-control" name="created_by" value="<?php echo $mtumiaji; ?>" readonly>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="form-group text-center mt-3">
        <input type="submit" name="submit" class="btn btn-success btn-lg" value="Hifadhi">
    </div>
</div>