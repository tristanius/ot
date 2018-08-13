<section>
  <form action="'<?= site_url('export/informe_items/') ?>'" method="post" class=" noMaterialStyles">
    <fieldset>
      <h5>Informe de items por OT (Inf. de PMO)</h5>
      <br>
      <div class="row" style="max-width: 800px">

        <div class="col m6 l6 s12 row" style="border: 1px solid #eee">
          <h6>Bases/ C.O. :</h6>
          <div class="col s6 l6 m6 row" ng-repeat="b in log.bases">
            <input class="col s2 m1 l1"
              type="checkbox"
              name="bases"
              value="{{b.idbase}}"
            >
            <label class="col s10 m11 l11 black-text">{{ b.idbase + ' - ' + b.nombre_base }}</label>
          </div>


        </div>

        <div class="col l6 m6 s12 right-align">
          Consultar:
          <button type="submit" class="btn light-green accent-4 text-black mini-btn" style="border-radius: 100%" data-icon=",">
          </button>
        </div>

      </div>
    </fieldset>
  </form>

</section>
