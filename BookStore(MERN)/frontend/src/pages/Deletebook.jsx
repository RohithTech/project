import {useState, useEffect} from 'react'
import { useParams } from 'react-router-dom'
import axios from 'axios'
import { useNavigate } from "react-router-dom";

function Deletebook() {
  const [remove, setRemove] = useState(false);
  const navigate = useNavigate();
  const { id } = useParams();

  useEffect(() => {
    let permit = confirm("Be careful, it cannot be recovered!");

    if (permit) {
      axios.delete(`http://localhost:5555/books/${id}`)
        .then(() => {
          setRemove(true);
          alert('Successfully deleted');

          setTimeout(() => {
            navigate("/");
          }, 100);
        })
        .catch((err) => {
          console.log(err);
        });
    } else {
      console.log('undeleted record');

      setTimeout(() => {
        navigate("/");
      }, 100);
    }
  }, []);

  return null;
}

export default Deletebook