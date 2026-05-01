import { BsArrowLeft } from 'react-icons/bs'
import { Link } from 'react-router-dom'
function Backbutton() {
    const destination = '/';
  return (
    <Link to={destination} className='flex bg-sky-800 px-4 py-1 rounded-lg w-fit'>
    <BsArrowLeft className='text-2xl'/>
    </Link>
  )
}

export default Backbutton