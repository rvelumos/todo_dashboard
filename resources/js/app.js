require('./bootstrap');

document.addEventListener('change', (e) => {
    if (!e.target?.form?.matches('.todo-item__form')) {
        return
    }

    const action = e.target.form.action;
    const data = new FormData(e.target.form);

    axios.post(action, Object.fromEntries(data.entries()))
        .catch(err => {
            console.error(err)
            e.target.checked = !e.target.checked
        })
})
