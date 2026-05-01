import express  from 'express'
import {PORT} from './config.js'
import {mongodburl} from './config.js'
import mongoose from 'mongoose'
import {Book} from './schemma/book.mjs'
import routers from './routes/bookroute.js'
import cors from 'cors'

const app = express();
app.use(cors({
    origin: 'http://localhost:5173',
}
))
app.use(express.json());
app.use('/books',routers)

// middleware for cors policy
// 1. allow all orgin with default of cors(*)
// 2. specify origin to access 
// app.use(cors({
//     origin:'https://localhost:3000',
//     methods:['GET','POST','PUT','DELETE'],
//     allowedHeaders:['Content-Type']
// }))
app.listen(PORT,()=>{
    console.log(`Everything okay:${PORT}`);
});
mongoose.connect(mongodburl)
.then(()=>{
    console.log('Connected successfully to MongoDB');
}
)
.catch((err)=>{
    console.log('Error occupied',err);
    
})

