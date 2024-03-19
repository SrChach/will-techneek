<style>
    .rating {
        display: inline-block;
        position: relative;
        height: 50px;
        line-height: 50px;
        font-size: 50px;
    }

    .rating label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        cursor: pointer;
    }

    .rating label:last-child {
        position: static;
    }

    .rating label:nth-child(1) {
        z-index: 5;
    }

    .rating label:nth-child(2) {
        z-index: 4;
    }

    .rating label:nth-child(3) {
        z-index: 3;
    }

    .rating label:nth-child(4) {
        z-index: 2;
    }

    .rating label:nth-child(5) {
        z-index: 1;
    }

    .rating label input {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .rating label .icon {
        float: left;
        color: transparent;
    }

    .rating label:last-child .icon {
        color: #000;
    }

    .rating:not(:hover) label input:checked~.icon,
    .rating:hover label:hover input~.icon {
        color: #09f;
    }

    .rating label input:focus:not(:checked)~.icon:last-child {
        color: #000;
        text-shadow: 0 0 5px #09f;
    }
</style>
<div class="form-check">
    <input type="radio" id="customRadio1" name="stars" class="form-check-input" value="1"
        @if ($calificacion == 1) checked @endif>
    <label class="form-check-label" for="customRadio1">
        <i class="fas fa-star text-warning"></i>
    </label>
</div>
<div class="form-check">
    <input type="radio" id="customRadio2" name="stars" class="form-check-input" value="2"
        @if ($calificacion == 2) checked @endif>
    <label class="form-check-label" for="customRadio2">
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
    </label>
</div>
<div class="form-check">
    <input type="radio" id="customRadio3" name="stars" class="form-check-input" value="3"
        @if ($calificacion == 3) checked @endif>
    <label class="form-check-label" for="customRadio3">
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
    </label>
</div>
<div class="form-check">
    <input type="radio" id="customRadio4" name="stars" class="form-check-input" value="4"
        @if ($calificacion == 4) checked @endif>
    <label class="form-check-label" for="customRadio4">
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
    </label>
</div>
<div class="form-check">
    <input type="radio" id="customRadio5" name="stars" class="form-check-input" value="5"
        @if ($calificacion == 5) checked @endif>
    <label class="form-check-label" for="customRadio5">
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
    </label>
</div>
