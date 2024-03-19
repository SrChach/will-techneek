<style>
    p.clasificacion {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    p.clasificacion input {
        position: absolute;
        top: -100px;
    }

    p.clasificacion label {
        float: right;
        color: #333;
    }

    p.clasificacion label:hover,
    p.clasificacion label:hover~label,
    p.clasificacion input:checked~label {
        color: #dd4;
    }
</style>

<label id="errorSarts"></label>

<p class="fs-2 clasificacion">
    <input id="radio1" type="radio" name="stars" value="5"
        @if ($calificacion == 5) checked="checked" @endif>
    <label for="radio1">★</label>
    <input id="radio2" type="radio" name="stars" value="4"
        @if ($calificacion == 4) checked="checked" @endif>
    <label for="radio2">★</label>
    <input id="radio3" type="radio" name="stars" value="3"
        @if ($calificacion == 3) checked="checked" @endif>
    <label for="radio3">★</label>
    <input id="radio4" type="radio" name="stars" value="2"
        @if ($calificacion == 2) checked="checked" @endif>
    <label for="radio4">★</label>
    <input id="radio5" type="radio" name="stars" value="1"
        @if ($calificacion == 1) checked="checked" @endif>
    <label for="radio5">★</label>
</p>
