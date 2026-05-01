import { useState, useEffect} from 'react'
import axios from 'axios'
import Backbutton from '../../components/Backbutton';
import { useParams } from 'react-router-dom';
import Spinner from '../../components/Spinner';
function Showbook() {
  const [book,setBook] = useState([]);
  const [loading,setLoading] = useState(false);
  const{ id }= useParams();

  useEffect(()=>{
    // setLoading(true)
    axios
    .get(`http://localhost:5555/books/${id}`)
    .then((res)=>{
      setBook(res.data);
      setLoading(false)
    })
    .catch((error)=>{
      console.log(error);
      setLoading(false);
    })
  },[])
  

  return (
    <div>
      <Backbutton/>
      <h1>Showbook</h1>
      {loading ?(
        <Spinner/>
      ):(
        
        <div className=' border border-blue-400 rounded-lg border-3 w-4/6 text-center justify-center items-center '>
          <div>
            <span className='text-xl mr-4 text-gray-500'>Book Id:{book._id}</span>
          </div>
          <div>
            <span className='text-xl mr-4 text-gray-500'>Title:{book.title}</span>
          </div>
          <div>
            <span className='text-xl mr-4 text-gray-500'>Author:{book.author}</span>
          </div>
          <div>
            <span className='text-xl mr-4 text-gray-500'>Published Year:{book.publishYear}</span>
          </div>
          <div>
            <span className='text-xl mr-4 text-gray-500'>Created Date:{book.createdAt}</span>
          </div>
          <div>
            <span className='text-xl mr-4 text-gray-500'>Updated Last:{book.updatedAt}</span>
          </div>
        </div>
      )
    }
    </div>
  )
}

export default Showbook