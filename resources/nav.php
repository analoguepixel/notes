<div class="row">
  <ul class="nav">
    <li class="nav active">
      <a href="/">
        <div class="link-button">
           Notes
        </div>
     </a>
    </li>
    <li>
    <?php
      if($data["editable"])
      {
    ?>
        <input id="save"
               type="submit" 
               class="center button button-primary"
               value="save">
        </li>
        <li>
        <input id="delete"
               type="submit" 
               class="center button button-primary"
               value="delete">
       </li>
    <?php
      }
    ?>
    <li class="nav logout active">
      <a href="/out/">
        <div class="link-button">
          Logout
        </div>
      </a>
    </li>
      <li class="nav logout active">
        <a href="/color/">
          <div class="link-button color-toggle">
            A
          </div>
        </a>
    </li>
  </ul>
</div>
