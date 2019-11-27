(function() {
  /**
   * post comment form
   */
  const commentSubmit = document.querySelector("form.comment-post [type=submit]");
  if (!!commentSubmit) {
    const authorInput = document.querySelector("input[name=author]");
    const commentInput = document.querySelector("textarea[name=comment]");
    commentSubmit.addEventListener(
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

  /**
   * delete comment body
   */
  const threadSection = document.getElementById("thread-list");
  if (!!threadSection) {
    const toggleTriggers = threadSection.querySelectorAll(".js-toggle-trigger[data-send]");
    Array.from(toggleTriggers, elem => {
      elem.addEventListener("click", e => {
        e.preventDefault();
        const target = e.target.dataset.send;
        const receiver = threadSection.querySelector(`[data-reciever=${target}]`);
        receiver.classList.toggle("hidden");
      });
    });
  }

  /**
   * delete comment form
   */
  const deleteSubmit = document.querySelectorAll("form.delete-comment");
  if (!!deleteSubmit) {
    Array.from(deleteSubmit, elem => {
      elem.addEventListener("submit", e => {
        if (!confirm("削除しますか？")) {
          e.preventDefault();
          return false;
        }
      });
    });
  }
})();
