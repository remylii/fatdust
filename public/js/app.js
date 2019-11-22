(function() {
  const btn = document.querySelector("form [type=submit]");
  const authorInput = document.querySelector("input[name=author]");
  const commentInput = document.querySelector("textarea[name=comment]");

  if (!!btn) {
    btn.addEventListener(
      "click",
      e => {
        if (authorInput.value === "" || commentInput.value === "") {
          return;
        }

        e.target.classList.add("disabled-action");
      },
      false
    );
  }
})();
