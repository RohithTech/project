import { useState, useEffect } from "react";
import axios from "axios";
import Backbutton from "../../components/Backbutton";
import Spinner from "../../components/Spinner";
import { useNavigate } from "react-router-dom";
function Createbook() {
  const [title, setTitle] = useState("");
  const [author, setAuthor] = useState("");
  const [publishYear, setPublishYear] = useState("");
  const [added, setAdded] = useState(false);

  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();

    const data = {
      title,
      author,
      publishYear,
    };

    axios
      .post("http://localhost:5555/books", data)
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
            Successfully Added Author
          </p>
        </div>
      ) : (
        <div>
          <form onSubmit={handleSubmit} method="post" className=" flex flex-col border-2 border-sky-400 rounded-xl w-[600px] p-4 mx-auto">
            <label htmlFor="author">Author:</label>
            <input
              type="text"
              name="author"
              id="author"
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
              Submit
            </button>
          </form>
        </div>
      )}
    </div>
  );
}

export default Createbook;
