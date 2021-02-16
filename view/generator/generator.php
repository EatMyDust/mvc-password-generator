
<div class="container">
    <div class="row">
        <div class="form">
            <form method="POST">
                <div class="form-group">
                    <input name="symbols" type="text" class="form-control <?=$result['model']->hasError('symbols') ? 'is-invalid':'';?>" id="symbols" placeholder="Number of symbols<?=$result['model']->isRequired('symbols');?>" value="">
                    <div class="invalid-feedback">
                        <?=$result['model']->getFirstError('symbols'); ?>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="numbers">
                    <label class="form-check-label" for="defaultCheck1">
                        Numbers without 0 and 1
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck2" name="big_letters">
                    <label class="form-check-label" for="defaultCheck2">
                        Big letters without o and O
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="defaultCheck3" name="small_letters">
                    <label class="form-check-label" for="defaultCheck3">
                        Small letters without "l"
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
            </form>
            <?=$result['code'];?>
        </div>
    </div>
</div>