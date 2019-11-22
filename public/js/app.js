(function() {
  const btn = document.querySelector("form [type=submit]");

  if (!!btn) {
    btn.addEventListener(
      "click",
      e => {
        console.log("submit");
        e.target.disabled = true;
      },
      false
    );
  }
})();
