import { useState, useEffect } from "react";
import axios from "axios";
import Backbutton from "../../components/Backbutton";
import Spinner from "../../components/Spinner";
import { useNavigate, useParams } from "react-router-dom";
function Editbook() {
  const [title, setTitle] = useState("");
  const [author, setAuthor] = useState("");
  const [publishYear, setPublishYear] = useState("");
  const [added, setAdded] = useState(false);
const {id} = useParams();
const navigate = useNavigate();

useEffect(()=>{
  // setAdded(true)
  axios.get(`http://localhost:5555/books/${id}`)
  .then((res)=>{
    setTitle(res.data.title)
    setAuthor(res.data.author)
    setPublishYear(res.data.publishYear)
    setAdded(false)
  })
  .catch((err)=>{
    console.log(err)
  })
},[])

  const handleEditSubmit = (e) => {
    e.preventDefault();

    const data = {
      title,
      author,
      publishYear,
    };

    axios
      .put(`http://localhost:5555/books/${id}`, data)
      .then(() => {
        setAdded(true);
      })
      .catch((err) => {
        console.log(err);
      });

    setTimeout(() => {
      navigate("/");
    }, 1000);
  };

  return (
    <div>
      <Backbutton />
      {added ? (
        <div className="justify-center flex">
          <p className="text-white text-2xl text-center bg-green-500 border border-green-300 p-4 m-4 rounded-2xl  w-9/12 ">
            Successfully edited Author
          </p>
        </div>
      ) : (
        <div>
          <form onSubmit={handleEditSubmit} method="post" className=" flex flex-col border-2 border-sky-400 rounded-xl w-[600px] p-4 mx-auto">
            <label htmlFor="author">Author:</label>
            <input
              type="text"
              name="author"
              id="author"
              value={author}
              onChange={(e) => setAuthor(e.target.value)}
              placeholder="Enter the name"
              required
              className="border border-2 m-2"
            />
            <br />
            <label htmlFor="title">Title:</label>
            <input
              type="text"
              name="title"
              id="title"
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              placeholder="Enter the title"
              required
              className="border border-2 m-2"
            />
            <br />
            <label htmlFor="publishYear">PublishYear:</label>
            <input
              type="number"
              name="publishYear"
              id="publishYear"
              value={publishYear}
              onChange={(e) => setPublishYear(e.target.value)}
              placeholder="Enter the Publish Year"
              required
              className="border border-2 m-2 "
            />
            <br />
            <button
              type="submit"
              className="border border-blue-300 bg-sky-400 text-white text-xl m-5 p-2 rounded-xl"
            >
              Update
            </button>
          </form>
        </div>
      )}
    </div>
  );
}

export default Editbook;
