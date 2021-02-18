
<div class="container">
    <div class="row">
        <div class="form col-12">
            <form method="POST" style="width: 300px;margin: 100px auto;">
                <div class="form-group">
                    <input name="symbols" type="text" class="form-control <?=$result['model']->hasError('symbols') ? 'is-invalid':'';?>" id="symbols" placeholder="Number of symbols<?=$result['model']->isRequired('symbols');?>" value="">
                    <div class="invalid-feedback">
                        <?=$result['model']->getFirstError('symbols'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="type[numbers]">
                        <label class="form-check-label" for="defaultCheck1">
                            Numbers without 0 and 1
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="defaultCheck2" name="type[big_letters]">
                        <label class="form-check-label" for="defaultCheck2">
                            Big letters without o and O
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="defaultCheck3" name="type[small_letters]">
                        <label class="form-check-label" for="defaultCheck3">
                            Small letters without "l"
                        </label>
                    </div>
                    <div class="invalid-feedback d-block">
                        <?=$result['model']->getFirstError('type'); ?>
                    </div>
                </div>
                <button style="width:100%;margin-top:10px;" type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
            </form>

            <? if(isset($result['code'])): ?>
            <div style="font-size:30px; text-align: center; margin-top:30px; word-break: break-all">
                <p>Your code is: </p>
                <p style="font-weight:bold; "><?=$result['code'];?></p>
            </div>
            <? endif; ?>
        </div>
    </div>
</div>