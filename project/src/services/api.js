import axios from "axios";

export function callAPI(formData) {
  return axios.post("api.php", formData, {
    headers: { "Content-Type": "multipart/form-data" }
  });
}
