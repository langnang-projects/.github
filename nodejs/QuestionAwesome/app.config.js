module.exports = {
    repo: "QuestionAwesome",
    owner: "langnang",
    api: "https://api.github.com",
    Requests: {
        issues: [
            {
                method: "GET",
                url: `${this.api}/issues`,
                params: {
                    filter: String,
                    state: String,
                    labels: String,
                    sort: String,
                    direction: String,
                    since: String,
                }
            }
        ]
    }
}