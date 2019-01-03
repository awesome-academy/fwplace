export default {
    async addSubject (context, data) {
        await axios.post('/subjects', {
            name: data.name,
            day: data.day
        })
    },

    async getSubject (context, data) {
        const types = await axios.get('subjects');

        return types.data;
    },

    async editSubject (context, data) {
        var obj = {};
        var key = data.column;
        obj[key] = data.type;
        await axios({
            method: 'patch', 
            url: 'subjects/' + data.id,
            data: obj
        });
    },

    async deleteSubject (context, data) {
        await axios.delete('/subjects/' + data.id)
    }
}
