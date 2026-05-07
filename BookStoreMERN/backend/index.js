import express  from 'express'
import path from 'path'
import dotenv from 'dotenv'
import mongoose from 'mongoose'
import {Book} from './schemma/book.mjs'
import routers from './routes/bookroute.js'
import cors from 'cors'

dotenv.config();

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
// const PORT = process.env.PORT ;
app.listen(process.env.PORT,()=>{
    console.log(`Everything okay:${process.env.PORT}`);
});

const __dirname = path.resolve();
if(process.env.NODE_ENV == 'production'){
    const frontendpath = path.join(__dirname,"..","frontend","dist")
    app.use(express.static(frontendpath))
    app.use('*',(req,res)=>{
        res.sendFile(path.join(frontendpath,'index.html'))
    })
}
// mongoose.connect(mongodburl)
mongoose.connect(process.env.MONGO_URL)
.then(()=>{
    console.log('Connected successfully to MongoDB');
}
)
.catch((err)=>{
    console.log('Error occupied',err);
    
})

