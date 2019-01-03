export default {
    getSubjects(context) {
        return new Promise((resolve, reject) => {
            axios.get('/subjects')
            .then(response => {
                resolve(response)
            })
            .catch(error => {
                reject(error)
            })
        })
    },

    getReports (context) {
        return new Promise ((resolve, reject) => {
            axios.get('reports')
            .then(response => {
                resolve(response.data)
            })
            .catch(error => {
                reject(error)
            })
        })
    },

    getReportsBySubject(context, data) {
        return new Promise ((resolve, reject) => {
            axios.get('reports/by/' + data.subject_id)
            .then(res => {
                resolve(res.data)
            })
            .catch(error => {
                reject(error)
            })
        })
    },

    async edit (context, data) {
        var obj = {};
        var key = data.column;
        obj[key] = data.contentEdit;
        await axios({
            method: 'patch', 
            url: 'reports/' + data.id,
            data: obj
        });
    }
}
