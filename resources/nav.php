<div class="row">
  <ul class="nav">
    <li class="nav active">
      <a href="/">
        <div class="link-button">
           Notes
        </div>
     </a>
    </li>
    <?php
      if($home == true)
      {
        ?>
        <li class="nav active">
          <a href="/new">
            <div class="link-button">
              New 
            </div>
         </a>
        </li>
        <?php
      }

      if($data["editable"])
      {
    ?>
        <li>
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
    <li class="nav logout">
      <a href="/profile/">
        <div class="link-button">
          <?=$_SESSION["user"]?>
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
